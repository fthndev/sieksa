<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request; // Tidak digunakan di method index ini
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse; // Untuk tipe return redirect
use Illuminate\View\View;             // Untuk tipe return view

class DashboardController extends Controller
{
    /**
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
                case 'admin':
                    // Pastikan route 'pj.dashboard' sudah ada di routes/web.php
                    return redirect()->route('admin.dashboard');
                default:
                    break;
            }
        }

        return view('dashboard', [
            'user' => $user // Tetap kirim data user ke view dashboard umum
        ]);
    }
}