<?php

namespace App\Http\Controllers\Musahil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Bisa dihapus jika tidak dipakai
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk Musahil.
     */
    public function index(): View
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user(); // Ini adalah instance Pengguna (Musahil) yang sedang login

        $listWargaDidampingi = collect(); // Inisialisasi sebagai koleksi kosong

        if ($user) {
            // Mengambil semua pengguna (warga) yang didampingi oleh musahil ini
            // Kita bisa memilih kolom tertentu untuk efisiensi jika tidak butuh semua data warga
            $listWargaDidampingi = $user->wargaDidampingi()->select('pengguna.nim', 'pengguna.nama', 'pengguna.email')->get();
            // Atau jika butuh semua data warga:
            // $listWargaDidampingi = $user->wargaDidampingi;
        }

        return view('musahil.dashboard', [
            'user' => $user,
            'listWargaDidampingi' => $listWargaDidampingi, // Mengirim daftar warga ke view
        ]);
    }
}