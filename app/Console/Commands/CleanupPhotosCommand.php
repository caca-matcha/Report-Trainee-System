<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupPhotosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-photos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus foto dokumentasi training (atmosphere) yang sudah lebih dari 6 bulan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sixMonthsAgo = now()->subMonths(6);
        
        $atmospheres = \App\Models\TrainingAtmosphere::where('created_at', '<', $sixMonthsAgo)
            ->whereHas('training', function($query) {
                $query->where('status', '!=', 'approved');
            })
            ->get();

        $count = 0;
        foreach ($atmospheres as $atmosphere) {
            if ($atmosphere->image_path) {
                // Hapus file fisik
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($atmosphere->image_path)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($atmosphere->image_path);
                }
                
                // Hapus data di database
                $atmosphere->delete();
                $count++;
            }
        }

        $this->info("Berhasil membersihkan $count foto dokumentasi training lama (lebih dari 6 bulan).");
    }
}
