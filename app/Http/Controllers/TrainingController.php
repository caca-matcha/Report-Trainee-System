<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Imports\TrainingImport;
use App\Imports\ObservationImport;
use App\Exports\ObservationTemplateExport;
use App\Exports\ParticipantTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::where('user_id', auth()->id())
            ->orderByRaw("
                CASE 
                    WHEN status = 'approved' AND start_date <= ? AND COALESCE(end_date, start_date) >= ? THEN 1
                    ELSE 2
                END ASC
            ", [now()->format('Y-m-d'), now()->format('Y-m-d')])
            ->latest()
            ->get();
        return view('trainings.index', compact('trainings'));
    }

    public function create()
    {
        return view('trainings.create');
    }

    public function show(Training $training)
    {
        $training->load(['participants', 'approvals.approver', 'summary']);
        return view('trainings.show', compact('training'));
    }

    public function update(Request $request, Training $training)
    {
        if ($request->has('status') && $request->status == 'approved') {
            $training->update(['status' => 'approved']);
            return back()->with('success', 'Training marked as complete.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'training_type' => 'required|string',
            'passing_grade' => 'required|numeric|min:0|max:100',
        ]);

        $training->update($validated);
        return redirect()->route('trainings.index')->with('success', 'Training updated.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'organizer' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'training_type' => 'required|string',
            'passing_grade' => 'required|numeric|min:0|max:100',
        ]);

        $request->user()->trainings()->create($validated);

        return redirect()->route('trainings.index')->with('success', 'Training created successfully.');
    }

    public function scoring(Training $training)
    {
        $training->load('participants');
        return view('trainings.scoring', compact('training'));
    }

    public function updateScoring(Request $request, Training $training)
    {
        $validated = $request->validate([
            'scores.*.post_test_score' => 'nullable|numeric|min:0|max:100',
            'scores.*.pre_test_score' => 'nullable|numeric|min:0|max:100',
            'scores.*.punctuality_score' => 'nullable|numeric|min:2|max:4',
            'scores.*.activeness_score' => 'nullable|numeric|min:2|max:4',
            'scores.*.cooperation_score' => 'nullable|numeric|min:2|max:4',
            'scores.*.attitude_score' => 'nullable|numeric|min:2|max:4',
            'scores.*.observation_score' => 'nullable|numeric|min:0|max:100',
            'scores.*.negotiation_score' => 'nullable|numeric|min:0|max:100',
        ]);

        $scores = $request->input('scores', []);

        foreach ($scores as $participantId => $data) {
            $participant = $training->participants()->find($participantId);
            if ($participant) {
                $participant->update([
                    'pre_test_score' => $data['pre_test_score'] ?? null,
                    'post_test_score' => $data['post_test_score'] ?? null,
                    'punctuality_score' => isset($data['punctuality_score']) ? round($data['punctuality_score'], 1) : null,
                    'activeness_score' => isset($data['activeness_score']) ? round($data['activeness_score'], 1) : null,
                    'cooperation_score' => isset($data['cooperation_score']) ? round($data['cooperation_score'], 1) : null,
                    'attitude_score' => isset($data['attitude_score']) ? round($data['attitude_score'], 1) : null,
                    'observation_score' => $data['observation_score'] ?? null,
                    'negotiation_score' => $data['negotiation_score'] ?? null,
                ]);
            }
        }

        return back()->with('success', 'Scores updated successfully.');
    }

    public function importForm(Training $training)
    {
        $training->load('participants');
        return view('trainings.import', compact('training'));
    }

    public function showAttendanceQr(Training $training)
    {
        // Link absen berlaku 24 jam (signed)
        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'trainings.presence',
            now()->addDay(),
            ['training' => $training->id]
        );

        return view('trainings.qr-show', compact('training', 'url'));
    }

    public function bulkAttendance(Training $training)
    {
        $training->participants()->update([
            'is_present' => true,
            'punctuality_score' => 100
        ]);

        return back()->with('success', 'Seluruh peserta berhasil ditandai Hadir.');
    }

    public function scanAttendance(Training $training)
    {
        return view('trainings.qr-scan', compact('training'));
    }

    public function processPresence(Request $request, Training $training)
    {
        if (!$request->hasValidSignature()) {
            abort(401, 'Link absensi tidak valid atau sudah kedaluwarsa.');
        }

        // Cek apakah masa berlaku training sudah berakhir
        $today = now()->startOfDay();
        $endDate = \Carbon\Carbon::parse($training->end_date)->endOfDay();
        
        if ($today->gt($endDate)) {
            abort(403, 'Masa berlaku absensi untuk training ini sudah berakhir.');
        }

        $participants = $training->participants()->orderBy('name')->get();

        return view('trainings.presence-confirm', compact('training', 'participants'));
    }

    public function submitPresence(Request $request, Training $training)
    {
        $request->validate([
            'participant_id' => 'required|exists:training_participants,id',
            'signature' => 'required|string',
        ]);

        $participant = $training->participants()->findOrFail($request->participant_id);

        if ($participant->is_present && $participant->signature_path) {
            return response()->json(['success' => false, 'message' => 'Peserta sudah melakukan absensi sebelumnya.'], 422);
        }

        if (!$participant) {
            return redirect()->route('dashboard')->with('error', 'Peserta tidak ditemukan.');
        }

        // Save signature image
        $signatureData = $request->signature;
        $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
        $signatureData = str_replace(' ', '+', $signatureData);
        $filename = 'signatures/' . $training->id . '_' . $participant->npk . '_' . time() . '.png';
        
        \Illuminate\Support\Facades\Storage::disk('public')->put($filename, base64_decode($signatureData));

        $participant->update([
            'is_present' => true,
            'signature_path' => $filename,
            'punctuality_score' => 100,
        ]);

        return response()->json(['success' => true, 'message' => 'Absensi berhasil! Tanda tangan Anda telah tersimpan.']);
    }

    public function removeParticipant(Training $training, \App\Models\TrainingParticipant $participant)
    {
        // Pastikan peserta memang milik training ini
        if ($participant->training_id !== $training->id) {
            abort(403);
        }

        $participant->delete();

        return back()->with('success', 'Peserta berhasil dihapus dari training.');
    }

    public function import(Request $request, Training $training)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new TrainingImport($training->id), $request->file('file'));

        return redirect()->route('admin.trainings.show', $training)->with('success', 'Participants imported successfully.');
    }

    public function exportObservationTemplate(Training $training)
    {
        $filename = 'Observation_Template_' . str_replace(' ', '_', $training->title) . '.xlsx';
        return Excel::download(new ObservationTemplateExport($training), $filename);
    }

    public function exportParticipantTemplate(Training $training)
    {
        $training->load('participants');
        $filename = 'Participant_Template_' . str_replace(' ', '_', $training->title) . '.xlsx';
        return Excel::download(new ParticipantTemplateExport($training), $filename);
    }

    public function importObservation(Request $request, Training $training)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new ObservationImport($training->id), $request->file('file'));

        return redirect()->route('admin.trainings.show', $training)->with('success', 'Observation scores imported successfully.');
    }

    public function syncObservationFromGoogleSheets(Request $request, Training $training)
    {
        try {
            $request->validate([
                'google_sheets_url' => 'required|url',
            ]);

            $url = $request->google_sheets_url;
            
            // Ensure it's a CSV export link if it's a standard google sheets link
            if (str_contains($url, 'docs.google.com/spreadsheets') && !str_contains($url, 'output=csv')) {
                if (preg_match('/\/d\/(.*?)(\/|$)/', $url, $matches)) {
                    $url = "https://docs.google.com/spreadsheets/d/{$matches[1]}/export?format=csv";
                }
            }

            $response = \Illuminate\Support\Facades\Http::get($url);
            
            if (!$response->successful()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengambil data dari Google Sheets. Pastikan link sudah di-"Publish to the Web" sebagai CSV.'], 400);
            }

            $csvData = $response->body();
            // Convert CSV string to collection of rows
            $rows = array_map('str_getcsv', explode("\n", trim($csvData)));
            $collection = collect($rows);

            // Reuse ObservationImport logic
            $import = new ObservationImport($training->id);
            $import->collection($collection);

            $training->update([
                'google_sheets_observation_url' => $request->google_sheets_url
            ]);

            return response()->json(['success' => true, 'message' => 'Data Observasi berhasil disinkronisasi dari Google Sheets.']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Observation Sync Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function approve(Training $training)
    {
        $training->update([
            'status' => 'approved',
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Laporan training berhasil disetujui (Approved).');
    }

    public function attendanceList(Training $training)
    {
        $training->load(['participants', 'user']);
        return view('summaries.attendance-list', compact('training'));
    }

    public function searchUsers(Request $request)
    {
        // This method is now officially removed as the system uses Import-Only workflow.
        return response()->json([]);
    }
}
