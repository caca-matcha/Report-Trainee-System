<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Training;

class TrainingOverviewController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Training::with(['user', 'participants', 'approvals']);

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Date-Based Phase Filter
        if ($request->filled('status') && $request->status !== 'all') {
            $today = now()->format('Y-m-d');
            if ($request->status === 'ongoing') {
                $query->where('start_date', '<=', $today)
                    ->where(function ($q) use ($today) {
                        $q->whereDate('end_date', '>=', $today)
                            ->orWhereNull('end_date');
                    });
            } elseif ($request->status === 'upcoming') {
                $query->where('start_date', '>', $today);
            } elseif ($request->status === 'archive') {
                $query->where(function ($q) use ($today) {
                    $q->whereDate('end_date', '<', $today)
                        ->orWhere(function ($sq) use ($today) {
                            $sq->whereNull('end_date')
                                ->whereDate('start_date', '<', $today);
                        });
                });
            }
        }
        $trainings = $query->latest()->paginate(10)->withQueryString();

        $today = now()->format('Y-m-d');
        $stats = [
            'total' => Training::count(),
            'ongoing' => Training::where('start_date', '<=', $today)
                ->where(function ($q) use ($today) {
                    $q->whereDate('end_date', '>=', $today)
                        ->orWhereNull('end_date');
                })->count(),
            'upcoming' => Training::where('start_date', '>', $today)->count(),
        ];

        return view('admin.trainings.index', compact('trainings', 'stats'));
    }

    public function show(Training $training)
    {
        $training->load(['user', 'participants', 'approvals.approver', 'summary', 'evaluation', 'atmospheres']);
        // Pull only "Trainee" (Employee) data for signatures as requested
        $users = User::where('role', 'trainee')
            ->orderBy('name')
            ->get(['id', 'name', 'npk', 'role'])
            ->unique('name');

        return view('admin.trainings.show', compact('training', 'users'));
    }
    public function destroy(Training $training)
    {
        // Hapus referensi training_id dari master_training jika ada
        \App\Models\MasterTraining::where('training_id', $training->id)
            ->update(['training_id' => null]);

        $training->delete();

        return redirect()->route('admin.trainings.index')
            ->with('success', 'Training berhasil dihapus.');
    }
}
