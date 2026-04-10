<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // PIC (Pembuat Training)
        User::factory()->create([
            'name' => 'PIC Staff',
            'email' => 'pic@example.com',
            'role' => 'pic',
            'department' => 'HRD',
            'password' => bcrypt('password'),
        ]);

        // SCH (Approver Level 2)
        User::factory()->create([
            'name' => 'SCH Approver',
            'email' => 'sch@example.com',
            'role' => 'sch',
            'department' => 'HRD',
            'password' => bcrypt('password'),
        ]);

        // DPH (Approver Level 3)
        User::factory()->create([
            'name' => 'DPH Approver',
            'email' => 'dph@example.com',
            'role' => 'dph',
            'department' => 'Management',
            'password' => bcrypt('password'),
        ]);

        // Deputy Div Head (Approver Level 4 - Final)
        User::factory()->create([
            'name' => 'Deputy Division Head',
            'email' => 'deputy@example.com',
            'role' => 'deputy',
            'department' => 'Board',
            'password' => bcrypt('password'),
        ]);
    }
}
