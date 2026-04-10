<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Training;

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = now()->format('Y-m-d');
        $stats = [
            'total_users' => User::count(),
            'total_trainings' => Training::count(),
            'ongoing' => Training::where('start_date', '<=', $today)
                ->where(function ($query) use ($today) {
                    $query->where('end_date', '>=', $today)
                        ->orWhereNull('end_date');
                })->count(),
            'upcoming' => Training::where('start_date', '>', $today)->count(),
            'archive' => Training::where(function ($query) use ($today) {
                $query->whereDate('end_date', '<', $today)
                      ->orWhere(function($sq) use ($today) {
                          $sq->whereNull('end_date')
                             ->whereDate('start_date', '<', $today);
                      });
            })->count(),
        ];

        // Prepare monthly trend data for Chart.js
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('M Y'));
        }

        $training_counts = Training::where('start_date', '>=', now()->subMonths(5)->startOfMonth())
            ->selectRaw("DATE_FORMAT(start_date, '%b %Y') as month, count(*) as total")
            ->groupBy('month')
            ->pluck('total', 'month');

        $trend_data = [
            'labels' => $months->values(),
            'data' => $months->map(fn($m) => $training_counts->get($m, 0))->values(),
        ];

        $recent_trainings = Training::with('user')
            ->orderByRaw("
                CASE 
                    WHEN start_date <= ? AND COALESCE(end_date, start_date) >= ? THEN 1
                    WHEN start_date > ? THEN 2
                    ELSE 3
                END ASC
            ", [$today, $today, $today])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_trainings', 'trend_data'));
    }
}
