<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;
use App\Models\User;

echo "Memulai sinkronisasi data dari API...\n";

$apiKey = env('API_KEY');
$baseUrl = rtrim(env('API_BASE_URL'), '/');

$response = Http::withoutVerifying()->withHeaders([
    'x-api-key' => $apiKey,
    'Accept'    => 'application/json',
])->get($baseUrl . '/hr/employees');

if (!$response->successful()) {
    echo "❌ Gagal terhubung ke API.\n";
    exit(1);
}

$body = $response->json();
$apiEmployees = $body['data'] ?? $body;
$total = count($apiEmployees);
echo "✅ Berhasil mengambil $total data dari API.\n";

$count = 0;
foreach ($apiEmployees as $emp) {
    if ($count % 500 == 0) {
        echo "Memproses: $count / $total\n";
    }
    
    $npk = $emp['npk'] ?? $emp['nik'] ?? $emp['employee_id'] ?? $emp['employee_code'] ?? $emp['nip'] ?? $emp['EMPLOYEE_NO'] ?? null;
    if (!$npk) continue;

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
    $count++;
}

echo "✅ Sinkronisasi SELESAI! Terproses: $count data.\n";
