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

        // Look up signatures based on names - prioritize users who actually have a signature
        $preparedSignature = User::where('name', $summary->prepared_by)
            ->orderByRaw('signature IS NULL, signature = ""')
            ->first()?->signature;
            
        $checkedSignature = User::where('name', $summary->checked_by)
            ->orderByRaw('signature IS NULL, signature = ""')
            ->first()?->signature;
            
        $confirmedSignature = User::where('name', $summary->confirmed_by)
            ->orderByRaw('signature IS NULL, signature = ""')
            ->first()?->signature;

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
            'checked_by' => 'nullable|string|max:255',
            'confirmed_by' => 'nullable|string|max:255',
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
        if ($request->has('prepared_by')) $summary->prepared_by = $request->prepared_by;
        if ($request->has('checked_by')) $summary->checked_by = $request->checked_by;
        if ($request->has('confirmed_by')) $summary->confirmed_by = $request->confirmed_by;
        if ($request->has('feedback_summary')) $summary->feedback_summary = $request->feedback_summary;

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
