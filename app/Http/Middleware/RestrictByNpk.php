<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RestrictByNpk
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            // 1. Trainees are ALWAYS allowed to login for presence/absensi
            if ($user->role === 'trainee') {
                return $next($request);
            }

            // 2. Allowed PIC/Admin NPKs
            $allowedNpks = [
                '11220079', // Luthfi Dhimas Widayanto
                '11220807', // Wisnu Prabowo
                '11230682', // Laja
                '11250360', // Dhenisa Titis Eksa Putri
                'ADMIN001', // Local Admin
            ];

            if (in_array($user->npk, $allowedNpks)) {
                return $next($request);
            }
        }

        // Logout and redirect with info if not authorized
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Akses ditolak. Hanya unit Learning yang diizinkan login sebagai Admin/PIC.');
    }
}
