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
        return view('musahil.dashboard', [
            'user' => $user,
        ]);
    }
}