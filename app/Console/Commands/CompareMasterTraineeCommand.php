<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\User;

class CompareMasterTraineeCommand extends Command
{
    protected $signature = 'app:compare-trainee';
    protected $description = 'Command description';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        return 0;
    }

    private function syncData($apiEmployees)
    {
        $bar = $this->output->createProgressBar(count($apiEmployees));
        $bar->start();

        foreach ($apiEmployees as $emp) {
            $npk = $emp['npk'] ?? $emp['nik'] ?? $emp['employee_id'] ?? $emp['employee_code'] ?? $emp['nip'] ?? $emp['EMPLOYEE_NO'] ?? null;
            if (!$npk) {
                $bar->advance();
                continue;
            }

            $name = $emp['name'] ?? $emp['full_name'] ?? $emp['nama'] ?? $emp['display_name'] ?? $emp['EMPLOYEE_NAME'] ?? 'Employee ' . $npk;
            $email = $emp['email'] ?? $emp['work_email'] ?? null;

            User::updateOrCreate(
                ['npk' => (string) $npk],
                [
                    'name'            => $name,
                    'email'           => $email,
                    'department'      => $emp['DEPARTMENT'] ?? $emp['division'] ?? null,
                    'subco'           => $emp['COMPANY'] ?? $emp['subco'] ?? null,
                    'employee_status' => $emp['EMPLOYEE_STATUS'] ?? $emp['status'] ?? 'active',
                    'role'            => 'trainee',
                    'password'        => \Illuminate\Support\Facades\Hash::make((string) $npk),
                ]
            );
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ Sinkronisasi SELESAI!");
    }
}
