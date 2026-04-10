<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class MasterTrainingController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterTraining::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('event_no', 'like', "%{$search}%")
                    ->orWhere('training_course', 'like', "%{$search}%")
                    ->orWhere('training_topic', 'like', "%{$search}%")
                    ->orWhere('provider', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->get('category'));
        }

        $trainings = $query->withCount('trainings')->latest()->paginate(10);
        $topTrainings = MasterTraining::withCount('trainings')->orderByDesc('trainings_count')->take(3)->get();

        return view('admin.master.trainings.index', compact('trainings', 'topTrainings'));
    }

    public function create()
    {
        $category = 'Mandatory';
        $eventNo = MasterTraining::generateNextEventNo($category);
        return view('admin.master.trainings.create', compact('eventNo', 'category'));
    }

    public function getNextCode(Request $request)
    {
        $category = $request->get('category', 'Mandatory');
        $code = MasterTraining::generateNextEventNo($category);
        return response()->json(['code' => $code]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_no' => 'required|string|max:50|unique:master_trainings,event_no',
            'category' => 'required|string|max:50',
            'training_course' => 'required|string|max:255',
            'training_topic' => 'required|string|max:255',
            'provider_type' => 'required|in:Internal,External',
            'provider' => 'required|string|max:255',
            'trainer_name' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'passing_grade' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'participants' => 'nullable|array',
            'trainers' => 'nullable|array',
            'pics' => 'nullable|array',
        ]);

        $validated['status'] = 'Open Registration';

        if (!empty($validated['participants'])) {
            $this->syncManualUsers($validated['participants']);
        }

        if (!empty($validated['trainers'])) {
            $this->syncManualUsers($validated['trainers']);
        }

        if (!empty($validated['pics'])) {
            $this->syncManualUsers($validated['pics']);
        }

        MasterTraining::create($validated);

        return redirect()->route('admin.master-trainings.index')->with('success', 'Master Training berhasil ditambahkan.');
    }

    public function show(MasterTraining $masterTraining)
    {
        return view('admin.master.trainings.show', compact('masterTraining'));
    }

    public function execute(MasterTraining $masterTraining)
    {
        return view('admin.master.trainings.execute', compact('masterTraining'));
    }

    public function storeExecution(Request $request, MasterTraining $masterTraining)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'training_topic' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'organizer' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'passing_grade' => 'required|numeric|min:0|max:100',
            'trainers' => 'nullable|array',
            'pics' => 'nullable|array',
            'participants' => 'nullable|array',
        ]);

        if (!empty($validated['participants'])) {
            $this->syncManualUsers($validated['participants']);
        }

        if (!empty($validated['trainers'])) {
            $this->syncManualUsers($validated['trainers']);
        }

        if (!empty($validated['pics'])) {
            $this->syncManualUsers($validated['pics']);
        }

        // Create new Training
        $training = \App\Models\Training::create([
            'user_id' => auth()->id(),
            'master_training_id' => $masterTraining->id,
            'title' => $masterTraining->training_course, // Force title to match master training
            'training_topic' => $validated['training_topic'] ?? $masterTraining->training_topic,
            'description' => $validated['description'] ?? $masterTraining->description,
            'organizer' => $validated['organizer'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'training_type' => $masterTraining->provider_type,
            'passing_grade' => $validated['passing_grade'],
            'status' => 'draft',
            'trainers' => $validated['trainers'],
            'pics' => $validated['pics'],
        ]);

        // Add participants
        if (!empty($validated['participants'])) {
            foreach ($validated['participants'] as $participant) {
                if (!empty($participant['name']) && !empty($participant['npk'])) {
                    $training->participants()->create([
                        'name' => $participant['name'],
                        'npk' => $participant['npk'],
                        'department' => $participant['department'] ?? '-',
                        'subco' => $participant['subco'] ?? '-',
                        'is_present' => false,
                    ]);
                }
            }
        }

        return redirect()->route('admin.trainings.show', $training)
            ->with('success', 'Berhasil mengeksekusi training dan mendaftarkan ' . count($validated['participants'] ?? []) . ' peserta!');
    }

    public function edit(MasterTraining $masterTraining)
    {
        return view('admin.master.trainings.edit', compact('masterTraining'));
    }

    public function update(Request $request, MasterTraining $masterTraining)
    {
        $validated = $request->validate([
            'event_no' => 'required|string|max:50|unique:master_trainings,event_no,' . $masterTraining->id,
            'category' => 'required|string|max:50',
            'training_course' => 'required|string|max:255',
            'training_topic' => 'required|string|max:255',
            'provider_type' => 'required|in:Internal,External',
            'provider' => 'required|string|max:255',
            'trainer_name' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'passing_grade' => 'required|numeric|min:0|max:100',
            'description' => 'nullable|string',
            'participants' => 'nullable|array',
            'trainers' => 'nullable|array',
            'pics' => 'nullable|array',
        ]);

        if (!empty($validated['participants'])) {
            $this->syncManualUsers($validated['participants']);
        }

        if (!empty($validated['trainers'])) {
            $this->syncManualUsers($validated['trainers']);
        }

        if (!empty($validated['pics'])) {
            $this->syncManualUsers($validated['pics']);
        }

        $masterTraining->update($validated);

        return redirect()->route('admin.master-trainings.index')->with('success', 'Master Training berhasil diperbarui.');
    }

    public function destroy(MasterTraining $masterTraining)
    {
        $masterTraining->delete();
        return redirect()->route('admin.master-trainings.index')->with('success', 'Master Training berhasil dihapus.');
    }

    public function exportCsv()
    {
        $fileName = 'master_trainings_' . date('Ymd_His') . '.csv';
        $trainings = MasterTraining::all();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('No. Training', 'Course', 'Topic', 'Provider Type', 'Provider', 'Start Date', 'End Date', 'Status');

        $callback = function () use ($trainings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($trainings as $training) {
                $row['No. Training'] = $training->event_no;
                $row['Course'] = $training->training_course;
                $row['Topic'] = $training->training_topic;
                $row['Provider Type'] = $training->provider_type;
                $row['Provider'] = $training->provider;
                $row['Start Date'] = \Carbon\Carbon::parse($training->start_date)->format('d/m/Y');
                $row['End Date'] = \Carbon\Carbon::parse($training->end_date)->format('d/m/Y');
                $row['Status'] = $training->status;

                fputcsv($file, array($row['No. Training'], $row['Course'], $row['Topic'], $row['Provider Type'], $row['Provider'], $row['Start Date'], $row['End Date'], $row['Status']));
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), "r");

        // Skip header
        fgetcsv($handle);

        $imported = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($data) >= 9) {
                MasterTraining::create([
                    'event_no' => $data[0],
                    'training_course' => $data[1],
                    'training_topic' => $data[2],
                    'provider_type' => $data[3],
                    'provider' => $data[4],
                    'start_date' => Carbon::createFromFormat('d/m/Y', $data[5])->format('Y-m-d'),
                    'end_date' => Carbon::createFromFormat('d/m/Y', $data[6])->format('Y-m-d'),
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'status' => $data[8],
                ]);
                $imported++;
            }
        }
        fclose($handle);

        return redirect()->route('admin.master-trainings.index')->with('success', "$imported data berhasil diimport.");
    }

    public function searchUsers(Request $request)
    {
        $search = $request->get('q');
        
        // Return uniquely based on NPK, prioritize those with better data
        $users = \App\Models\User::where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('npk', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
            ->select('id', 'name', 'npk', 'email', 'department', 'subco', 'photo')
            ->orderByRaw('CASE WHEN npk IS NOT NULL THEN 0 ELSE 1 END') // Official NPK first
            ->orderByRaw('CASE WHEN photo IS NOT NULL THEN 0 ELSE 1 END') // Then Photo
            ->orderByRaw('CASE WHEN department IS NOT NULL AND department != "-" THEN 0 ELSE 1 END') // Then Dept
            ->limit(50) 
            ->get()
            ->map(function($user) {
                return [
                    'name' => $user->name,
                    'npk' => $user->npk ?: $user->email, // The "Visual" NPK
                    'department' => $user->department ?: '-',
                    'subco' => $user->subco ?: '-',
                    'photo' => $user->photo ? asset('storage/' . $user->photo) : null
                ];
            })
            ->unique('npk') // Unique by visual NPK (handles null vs email correctly)
            ->values()
            ->take(10);

        return response()->json($users);
    }

    private function syncManualUsers(array $users)
    {
        foreach ($users as $u) {
            if (!empty($u['npk']) && !empty($u['name'])) {
                // If it's manual or just not in system, attempt to create/update
                $email = strtolower(str_replace(' ', '.', $u['name'])) . rand(100, 999) . '@system.local';
                
                \App\Models\User::firstOrCreate(
                    ['npk' => $u['npk']],
                    [
                        'name' => $u['name'],
                        'department' => $u['department'] ?? '-',
                        'subco' => $u['subco'] ?? '-',
                        'email' => $email,
                        'password' => bcrypt('password'),
                        'role' => 'trainee', // Default role
                    ]
                );
            }
        }
    }
}
