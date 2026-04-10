<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportKaryawan extends Command
{
    protected $signature   = 'import:karyawan {--file=datakaryawan.json : Path file JSON relatif dari root proyek}';
    protected $description = 'Import data karyawan dari file JSON ke tabel users';

    public function handle(): int
    {
        $filePath = base_path($this->option('file'));

        if (!file_exists($filePath)) {
            $this->error("File tidak ditemukan: {$filePath}");
            return self::FAILURE;
        }

        $this->info("Membaca file JSON...");
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("File JSON tidak valid: " . json_last_error_msg());
            return self::FAILURE;
        }

        $employees = $data['data'] ?? $data;

        if (empty($employees)) {
            $this->error("Data kosong di dalam JSON.");
            return self::FAILURE;
        }

        $total   = count($employees);
        $created = 0;
        $skipped = 0;
        $now     = now()->toDateTimeString();

        $this->info("Total data karyawan: {$total}");
        $this->info("Memulai import...");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        // Batch insert per 500 records
        $chunks = array_chunk($employees, 500);

        foreach ($chunks as $chunk) {
            $insertData = [];

            foreach ($chunk as $emp) {
                $npk  = (string) ($emp['EMPLOYEE_NO'] ?? '');
                $name = (string) ($emp['EMPLOYEE_NAME'] ?? '');
                $dept = (string) ($emp['DEPARTMENT'] ?? '');

                $insertData[] = [
                    'name'       => $name,
                    'npk'        => $npk,
                    'email'      => null,
                    'department' => $dept,
                    'subco'      => (string) ($emp['COMPANY'] ?? ''),
                    'role'       => 'trainee',
                    'employee_status' => (string) ($emp['EMPLOYEE_STATUS'] ?? $emp['status'] ?? 'active'),
                    'password'   => Hash::make($npk),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $bar->advance();
            }

            if (!empty($insertData)) {
                DB::table('users')->upsert($insertData, ['npk'], ['name', 'department', 'subco', 'employee_status', 'password', 'updated_at']);
                $created += count($insertData);
            }
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ Import selesai!");
        $this->table(
            ['Keterangan', 'Jumlah'],
            [
                ['Total data', $total],
                ['Berhasil dibuat', $created],
                ['Dilewati (duplikat/kosong)', $skipped],
            ]
        );

        return self::SUCCESS;
    }
}
