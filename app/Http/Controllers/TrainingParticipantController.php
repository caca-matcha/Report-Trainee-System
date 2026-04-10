<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\TrainingParticipant;

class TrainingParticipantController extends Controller
{
    public function create(Training $training)
    {
        return view('participants.create', compact('training'));
    }

    public function store(Request $request, Training $training)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'npk' => 'required|string|max:20',
            'department' => 'required|string|max:100',
            'pre_test_score' => 'nullable|numeric|min:0|max:100',
        ]);

        $training->participants()->create($validated);

        return redirect()->route('trainings.show', $training)->with('success', 'Participant added.');
    }

    public function destroy(TrainingParticipant $participant)
    {
        $training = $participant->training;
        $participant->delete();
        return redirect()->route('trainings.show', $training)->with('success', 'Participant removed.');
    }

    public function toggleAttendance(TrainingParticipant $participant)
    {
        $participant->update([
            'is_present' => !$participant->is_present
        ]);

        return response()->json([
            'success' => true,
            'is_present' => $participant->is_present,
            'message' => 'Status kehadiran berhasil diperbarui.'
        ]);
    }

    public function updateScore(Request $request, TrainingParticipant $participant)
    {
        $type = $request->input('type');
        $isSoftSkill = in_array($type, ['punctuality', 'activeness', 'cooperation', 'attitude']);
        
        $validated = $request->validate([
            'type' => 'required|in:pre_test,post_test,punctuality,activeness,cooperation,attitude',
            'value' => 'nullable|numeric|min:0|max:' . ($isSoftSkill ? '5' : '100')
        ]);

        $scoreField = $validated['type'] . '_score';
        
        $updateData = [$scoreField => $validated['value']];
        
        // Auto-Hadir: Jika ada nilai yang masuk, set is_present ke true
        if ($validated['value'] !== null && !$participant->is_present) {
            $updateData['is_present'] = true;
        }

        $participant->update($updateData);

        return response()->json([
            'success' => true,
            'is_present' => $participant->is_present,
            'message' => 'Skor berhasil diperbarui.'
        ]);
    }

    public function updateField(Request $request, TrainingParticipant $participant)
    {
        $validated = $request->validate([
            'field' => 'required|in:subco,department,name',
            'value' => 'nullable|string|max:255'
        ]);

        $participant->update([
            $validated['field'] => $validated['value'] ?? '-'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui.'
        ]);
    }
}
