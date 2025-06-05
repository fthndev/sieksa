<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request; // Tidak digunakan di method index ini
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse; // Untuk tipe return redirect
use Illuminate\View\View;             // Untuk tipe return view

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard yang sesuai berdasarkan role pengguna setelah login,
     * atau menampilkan dashboard umum jika tidak ada role spesifik yang cocok atau
     * jika ini adalah tujuan akhir yang diinginkan.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index() // Menggunakan tipe return gabungan jika ada fallback view
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user(); // Mendapatkan instance Pengguna yang sedang login

        // Pastikan pengguna ada dan memiliki atribut 'role'
        if ($user && isset($user->role)) {
            // Menggunakan trim() dan strtolower() untuk perbandingan yang lebih aman
            switch (trim(strtolower($user->role))) {
                case 'warga':
                    // Pastikan route 'warga.dashboard' sudah ada di routes/web.php
                    return redirect()->route('warga.dashboard');
                case 'musahil':
                    // Pastikan route 'musahil.dashboard' sudah ada di routes/web.php
                    return redirect()->route('musahil.dashboard');
                case 'pj':
                    // Pastikan route 'pj.dashboard' sudah ada di routes/web.php
                    return redirect()->route('pj.dashboard');
                default:
                    // Jika role tidak dikenali, atau Anda ingin dashboard umum untuk role lain,
                    // bisa jatuh ke return view('dashboard') di bawah.
                    // Atau Anda bisa secara eksplisit menangani role yang tidak dikenal di sini,
                    // misalnya dengan redirect ke halaman error atau logout.
                    // Untuk contoh ini, kita biarkan jatuh ke view dashboard umum.
                    break;
            }
        }

        // Jika pengguna tidak memiliki role, atau role tidak cocok dengan case di atas,
        // atau jika ini memang dashboard umum yang ingin ditampilkan.
        // Pastikan Anda memiliki view 'resources/views/dashboard.blade.php'
        // yang bisa menampilkan pesan generik seperti "You're logged in!"
        // atau konten dashboard umum.
        return view('dashboard', [
            'user' => $user // Tetap kirim data user ke view dashboard umum
        ]);
    }
}