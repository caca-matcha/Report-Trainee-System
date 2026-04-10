<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$apiKey = env('API_KEY');
$baseUrl = rtrim(env('API_BASE_URL'), '/');

echo "Searching for Ibnu Bagas (11230236) in API ...\n";

$response = Http::withoutVerifying()->withHeaders([
    'x-api-key' => $apiKey,
    'Accept'    => 'application/json',
])->get($baseUrl . '/hr/employees');

if ($response->successful()) {
    $data = $response->json();
    $employees = $data['data'] ?? $data;
    
    foreach ($employees as $emp) {
        $npk = $emp['npk'] ?? $emp['nik'] ?? $emp['employee_id'] ?? $emp['employee_code'] ?? $emp['nip'] ?? $emp['EMPLOYEE_NO'] ?? null;
        if ($npk == '11230236') {
            echo "Found Employee Data:\n";
            print_r($emp);
            exit;
        }
    }
    echo "Employee not found in API response.\n";
} else {
    echo "Request failed with status: " . $response->status() . "\n";
}
