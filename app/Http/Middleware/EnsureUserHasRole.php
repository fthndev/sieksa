<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  array<string>  ...$allowedRoles  // Role-role yang diizinkan untuk mengakses route
     */
    public function handle(Request $request, Closure $next, ...$allowedRoles): Response
    {
        // 1. Pastikan pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, arahkan ke halaman login
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        /** @var \App\Models\Pengguna $user */
        $user = $request->user();

        // 2. Cek apakah pengguna memiliki salah satu dari role yang diizinkan
        $hasPermission = false;
        if ($user && method_exists($user, 'hasRole')) { // Pastikan method hasRole ada di model Pengguna
            foreach ($allowedRoles as $role) {
                if ($user->hasRole(trim($role))) { // trim() untuk menghapus spasi jika ada
                    $hasPermission = true;
                    break; // Jika satu role cocok, izin diberikan
                }
            }
        } else {
            // Jika objek user tidak ada atau tidak memiliki method hasRole (seharusnya tidak terjadi jika setup benar)
            // Anda bisa log error ini atau redirect dengan pesan umum
            // Log::error('User object or hasRole method missing in EnsureUserHasRole middleware for user ID: ' . ($user ? $user->getKey() : 'Guest'));
            return redirect('/login')->with('error', 'Terjadi kesalahan dalam verifikasi peran pengguna.');
        }


        // 3. Jika tidak memiliki izin
        if (!$hasPermission) {
            // Anda bisa mengarahkan ke halaman login, halaman utama, atau menampilkan error 403.
            // abort(403, 'ANDA TIDAK MEMILIKI AKSES UNTUK HALAMAN INI.');
            // Atau redirect dengan pesan error yang lebih ramah:
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
            // Jika tidak ada halaman 'back', mungkin lebih baik redirect ke dashboard umum atau halaman utama.
            // return redirect(route('dashboard'))->with('error', 'Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        }

        // Jika memiliki izin, lanjutkan ke request berikutnya
        return $next($request);
    }
}