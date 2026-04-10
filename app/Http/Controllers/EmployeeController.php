<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class EmployeeController extends Controller
{
    private function getHeaders(): array
    {
        return [
            'x-api-key' => env('API_KEY'),
            'Accept'    => 'application/json',
        ];
    }

    private function baseUrl(): string
    {
        return rtrim(env('API_BASE_URL', 'https://msa-be.dharmagroup.co.id/api/v1'), '/');
    }

    /**
     * Tampilkan daftar semua employees dari API.
     */
    public function index()
    {
        /** @var Response $response */
        $response = Http::withHeaders($this->getHeaders())
            ->get($this->baseUrl() . '/hr/employees');

        if (!$response->successful()) {
            return back()->withErrors('Gagal mengambil data employees dari API. Status: ' . $response->status());
        }

        $body      = $response->json();
        $employees = $body['data'] ?? $body;

        return view('employees.index', compact('employees'));
    }

    /**
     * Tampilkan detail satu employee.
     */
    public function show(string $id)
    {
        /** @var Response $response */
        $response = Http::withHeaders($this->getHeaders())
            ->get($this->baseUrl() . '/hr/employees/' . $id);

        if (!$response->successful()) {
            return back()->withErrors('Data employee tidak ditemukan.');
        }

        $body     = $response->json();
        $employee = $body['data'] ?? $body;

        return view('employees.show', compact('employee'));
    }
}
