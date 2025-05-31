<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan facade Auth di-import
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  // Role yang diharapkan untuk mengakses route
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah pengguna sudah login dan memiliki role yang sesuai.
        // Kita akan menggunakan method hasRole() yang akan kita tambahkan di model Pengguna.
        if (!Auth::check() || !$request->user()->hasRole($role)) {
            // Jika tidak, redirect atau tampilkan error 403 (Forbidden)
            // Anda bisa mengarahkan ke halaman login, halaman utama, atau menampilkan error.
            // abort(403, 'ANDA TIDAK MEMILIKI AKSES UNTUK HALAMAN INI.');
            // Atau redirect ke halaman login dengan pesan error
            return redirect('/login')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        }

        return $next($request);
    }
}