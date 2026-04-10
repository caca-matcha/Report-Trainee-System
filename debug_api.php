<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$apiKey = env('API_KEY');
$baseUrl = rtrim(env('API_BASE_URL'), '/');

echo "Fetching from: $baseUrl/hr/employees ...\n";

$response = Http::withoutVerifying()->withHeaders([
    'x-api-key' => $apiKey,
    'Accept'    => 'application/json',
])->get($baseUrl . '/hr/employees');

if ($response->successful()) {
    $data = $response->json();
    $employees = $data['data'] ?? $data;
    
    if (!empty($employees)) {
        echo "Found " . count($employees) . " employees.\n";
        echo "First employee data sample:\n";
        print_r($employees[0]);
    } else {
        echo "No employees found in response.\n";
    }
} else {
    echo "Request failed with status: " . $response->status() . "\n";
    echo $response->body() . "\n";
}
