<?php

namespace App\Http\Controllers\pj;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB Facade
use Illuminate\View\View;
use App\Models\User;

class ListWargaDidampingPj extends Controller
{
    public function index(): View
    {
        /** @var User $loggedInUser */
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            return redirect('/login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        // Mengambil NIM dari pengguna yang sedang login
        // Asumsi kolom NIM di tabel user Anda adalah 'nim'
        $nimMusahil = $loggedInUser->nim;

        // --- Proses Query Menggunakan Query Builder (Sesuai Skema DB Anda) ---
        // Nama tabel pendampingan: 'musahil_pendamping' (sesuai skema Anda)
        // Nama tabel pengguna: 'pengguna' (sesuai skema Anda)
        // Kolom NIM di tabel pengguna: 'nim'
        // Kolom nama di tabel pengguna: 'nama'
        $list_dampingi = DB::table('musahil_pendamping') // <-- Disesuaikan dengan skema Anda!
            ->join('pengguna', 'musahil_pendamping.id_warga', '=', 'pengguna.nim') // <-- Disesuaikan dengan skema Anda!
            ->where('musahil_pendamping.id_musahil_pendamping', $nimMusahil)
            ->select(
                'musahil_pendamping.id_pendaping',
                'musahil_pendamping.id_musahil_pendamping',
                'musahil_pendamping.id_warga', // Ini adalah NIM warga
                'pengguna.nama as nama_warga',
                'pengguna.id_ekstrakurikuler as id_ekstra_warga',
                'pengguna.email as email_warga' // <-- Disesuaikan dengan skema Anda: 'pengguna.nama'
            )
            ->get();

        // Mengirimkan koleksi data ke view.
        // Nama view tetap 'musahil.list-warga'
        return view('pj.list-warga', ['list_dampingi' => $list_dampingi]);
    }
}
