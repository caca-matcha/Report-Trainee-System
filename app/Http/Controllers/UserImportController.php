<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class UserImportController extends Controller
{
    /**
     * Halaman sinkronisasi user dari API.
     */
    public function index()
    {
        $totalUsers = User::count();
        return view('admin.import-users', compact('totalUsers'));
    }

    /**
     * Jalankan proses import user dari API employees.
     */
    public function import(Request $request)
    {
        set_time_limit(0); // Mencegah timeout untuk data besar (9000+ user)

        /** @var Response $response */
        $response = Http::withoutVerifying()->withHeaders([
            'x-api-key' => env('API_KEY'),
            'Accept' => 'application/json',
        ])->get(rtrim(env('API_BASE_URL'), '/') . '/hr/employees');

        if (!$response->successful()) {
            $errorMessage = 'Gagal terhubung ke API pusat. Status: ' . $response->status();
            if ($request->ajax()) {
                return response()->json([
                    'success' => false, 
                    'message' => $errorMessage
                ], 400); // Return error as JSON for AJAX
            }
            return back()->withErrors($errorMessage);
        }

        $body = $response->json();
        $employees = $body['data'] ?? $body;

        if (empty($employees) || !is_array($employees)) {
            $errorMessage = 'Data dari API kosong atau formatnya tidak sesuai.';
            if ($request->ajax()) {
                return response()->json([
                    'success' => false, 
                    'message' => $errorMessage
                ], 400);
            }
            return back()->withErrors($errorMessage);
        }

        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($employees as $emp) {
            // Cari field NPK dari kemungkinan nama field
            $npk = $emp['npk'] ?? $emp['nik'] ?? $emp['employee_id'] ?? $emp['employee_code'] ?? $emp['nip'] ?? $emp['EMPLOYEE_NO'] ?? null;

            if (!$npk) {
                $skipped++;
                continue;
            }

            // Cari nama dari kemungkinan nama field
            $name = $emp['name'] ?? $emp['full_name'] ?? $emp['nama'] ?? $emp['display_name'] ?? $emp['EMPLOYEE_NAME'] ?? 'Employee ' . $npk;

            // Cari email (opsional)
            $email = $emp['email'] ?? $emp['work_email'] ?? null;

            $existing = User::where('npk', (string)$npk)->first();

            if ($existing) {
                $existing->update([
                    'name' => $name,
                    'email' => $email,
                    'department' => $emp['DEPARTMENT'] ?? $emp['division'] ?? null,
                    'organization_unit' => $emp['ORGANIZATION_UNIT'] ?? null,
                    'subco' => $emp['COMPANY'] ?? $emp['subco'] ?? null,
                    'employee_status' => $emp['EMPLOYEE_STATUS'] ?? $emp['status'] ?? 'active',
                ]);
                $updated++;
            }
            else {
                User::create([
                    'name' => $name,
                    'npk' => (string)$npk,
                    'email' => $email,
                    'department' => $emp['DEPARTMENT'] ?? $emp['division'] ?? null,
                    'organization_unit' => $emp['ORGANIZATION_UNIT'] ?? null,
                    'subco' => $emp['COMPANY'] ?? $emp['subco'] ?? null,
                    'employee_status' => $emp['EMPLOYEE_STATUS'] ?? $emp['status'] ?? 'active',
                    'password' => bcrypt((string)$npk), // Password default = NPK
                ]);
                $created++;
            }
        }

        $message = "Sinkronisasi selesai! Dibuat: {$created} user baru, diperbarui: {$updated} user, dilewati: {$skipped}.";

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'total_users' => User::count()
            ]);
        }

        return redirect()->route('admin.import-users.index')->with('success', $message);
    }
}
