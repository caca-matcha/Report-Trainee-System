<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Training;
use App\Models\TrainingSummary;
use App\Models\TrainingParticipant;


class TrainingSummaryController extends Controller
{
    public function show(Training $training)
    {
        $training->load(['evaluation', 'atmospheres']);
        // dd($training->evaluation); // Uncomment this to debug
        $participants = $training->participants;
        $totalInvitation = $participants->count();
        $totalAttend = $participants->where('is_present', true)->count();
        $totalAbsent = $totalInvitation - $totalAttend;

        $avgPreTest = $participants->where('is_present', true)->avg('pre_test_score') ?? 0;
        $avgPostTest = $participants->where('is_present', true)->avg('post_test_score') ?? 0;

        // Soft skills averages (1-4 scale)
        $avgPunctuality = round($participants->where('is_present', true)->avg('punctuality_score') ?? 0, 1);
        $avgActiveness = round($participants->where('is_present', true)->avg('activeness_score') ?? 0, 1);
        $avgCooperation = round($participants->where('is_present', true)->avg('cooperation_score') ?? 0, 1);
        $avgAttitude = round($participants->where('is_present', true)->avg('attitude_score') ?? 0, 1);

        $passCount = $participants->filter(function ($p) use ($training) {
            return $p->is_present && $p->post_test_score >= $training->passing_grade;
        })->count();

        $attendanceRatio = $totalInvitation > 0 ? round(($totalAttend / $totalInvitation) * 100) : 0;

        $summary = $training->summary ?? new TrainingSummary();

        // Auto-fill prepared_by if empty from PICs
        if (empty($summary->prepared_by) && !empty($training->pics)) {
            foreach ($training->pics as $pic) {
                if (isset($pic['department']) && str_contains(strtoupper($pic['department']), 'LEARNING & DEVELOPMENT')) {
                    $summary->prepared_by = $pic['name'];
                    break;
                }
            }
        }

        // Pull Trainees + PICs/Admins from L&D for signatures
        $users = User::where(function($q) {
            $q->where('role', 'trainee')
              ->orWhere(function($sq) {
                  $sq->whereIn('role', ['admin', 'pic'])
                     ->where('department', 'LIKE', '%Learning & Development%');
              });
        })
            ->orderBy('name')
            ->get(['id', 'name', 'npk', 'role'])
            ->unique('name');

        // Look up signatures based on names with partial matches for flexibility
        $preparedSignature = !empty($summary->prepared_by) 
            ? User::where('name', 'like', '%' . trim($summary->prepared_by) . '%')
                  ->whereNotNull('signature')->where('signature', '!=', '')
                  ->first()?->signature 
            : null;
            
        $checkedSignature = !empty($summary->checked_by)
            ? User::where('name', 'like', '%' . trim($summary->checked_by) . '%')
                  ->whereNotNull('signature')->where('signature', '!=', '')
                  ->first()?->signature 
            : null;
            
        $confirmedSignature = !empty($summary->confirmed_by)
            ? User::where('name', 'like', '%' . trim($summary->confirmed_by) . '%')
                  ->whereNotNull('signature')->where('signature', '!=', '')
                  ->first()?->signature 
            : null;

        return view('summaries.show', compact(
            'training',
            'participants',
            'totalInvitation',
            'totalAttend',
            'totalAbsent',
            'avgPreTest',
            'avgPostTest',
            'avgPunctuality',
            'avgActiveness',
            'avgCooperation',
            'avgAttitude',
            'passCount',
            'attendanceRatio',
            'summary',
            'users',
            'preparedSignature',
            'checkedSignature',
            'confirmedSignature'
        ));
    }

    public function store(Request $request, Training $training)
    {
        $validated = $request->validate([
            'recommendation' => 'nullable|string',
            'prepared_by' => 'nullable|string|max:255',
            'prepared_title' => 'nullable|string|max:255',
            'prepared_header' => 'nullable|string|max:255',
            'checked_by' => 'nullable|string|max:255',
            'checked_title' => 'nullable|string|max:255',
            'checked_header' => 'nullable|string|max:255',
            'confirmed_by' => 'nullable|string|max:255',
            'confirmed_title' => 'nullable|string|max:255',
            'confirmed_header' => 'nullable|string|max:255',
            'barcode_image' => 'nullable|image|max:2048', // for legacy or single field
            'image_file' => 'nullable|image|max:2048', // new generic field
            'target_field' => 'nullable|string|in:barcode_path,prepared_barcode_path,checked_barcode_path',
            'feedback_summary' => 'nullable|string',
            'trainer_feedbacks_key' => 'nullable|integer',
            'trainer_feedbacks_value' => 'nullable|string',
            'trainer_impressions_key' => 'nullable|integer',
            'trainer_impressions_value' => 'nullable|string',
        ]);

        if ($training->status == 'approved') {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Laporan sudah di-lock (approved) dan tidak bisa diubah.'], 403);
            }
            return back()->with('error', 'Laporan sudah di-lock (approved) dan tidak bisa diubah.');
        }

        $summary = $training->summary ?? new TrainingSummary(['training_id' => $training->id]);
        
        if ($request->has('recommendation')) $summary->recommendation = $request->recommendation;

        
        if ($request->has('prepared_by')) {
            if ($summary->prepared_by !== $request->prepared_by) {
                $summary->prepared_barcode_path = null;
            }
            $summary->prepared_by = $request->prepared_by;
        }
        if ($request->has('prepared_title')) $summary->prepared_title = $request->prepared_title;
        if ($request->has('prepared_header')) $summary->prepared_header = $request->prepared_header;
        
        if ($request->has('checked_by')) {
            if ($summary->checked_by !== $request->checked_by) {
                $summary->checked_barcode_path = null;
            }
            $summary->checked_by = $request->checked_by;
        }
        if ($request->has('checked_title')) $summary->checked_title = $request->checked_title;
        if ($request->has('checked_header')) $summary->checked_header = $request->checked_header;
        
        if ($request->has('confirmed_by')) {
            if ($summary->confirmed_by !== $request->confirmed_by) {
                $summary->barcode_path = null;
            }
            $summary->confirmed_by = $request->confirmed_by;
        }
        if ($request->has('confirmed_title')) $summary->confirmed_title = $request->confirmed_title;
        if ($request->has('confirmed_header')) $summary->confirmed_header = $request->confirmed_header;
        
        if ($request->has('feedback_summary')) $summary->feedback_summary = $request->feedback_summary;

        // Handle Image Upload (Generic)
        if ($request->hasFile('image_file') && $request->target_field) {
            $path = $request->file('image_file')->store('barcodes', 'public');
            $field = $request->target_field;
            $summary->$field = $path;
        }

        // Handle Barcode Image Upload (Legacy/Compatibility)
        if ($request->hasFile('barcode_image')) {
            $path = $request->file('barcode_image')->store('barcodes', 'public');
            $summary->barcode_path = $path;
        }

        if ($request->has('trainer_feedbacks_key')) {
            $feedbacks = $summary->trainer_feedbacks ?? [];
            $feedbacks[$request->trainer_feedbacks_key] = $request->trainer_feedbacks_value;
            $summary->trainer_feedbacks = $feedbacks;
        }

        if ($request->has('trainer_impressions_key')) {
            $impressions = $summary->trainer_impressions ?? [];
            $impressions[$request->trainer_impressions_key] = $request->trainer_impressions_value;
            $summary->trainer_impressions = $impressions;
        }

        $summary->save();

        if ($request->has('trainers')) {
            $training->update(['trainers' => $request->trainers]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Summary updated successfully.']);
        }

        return back()->with('success', 'Summary updated successfully.');
    }
}
