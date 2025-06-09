<?php

namespace App\Http\Controllers\PJ;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler; // Import model Ekstrakurikuler
use Illuminate\Http\Request;    // Bisa dihapus jika tidak digunakan
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // Untuk memastikan PJ yang akses adalah PJ yang berhak (opsional)

class EkstrakurikulerController extends Controller
{
    // ... (method create, store, index, edit, update, destroy Anda mungkin ada di sini) ...

    /**
     * Menampilkan daftar peserta untuk ekstrakurikuler tertentu.
     *
     * @param  \App\Models\Ekstrakurikuler  $ekstrakurikuler
     * @return \Illuminate\View\View
     */
    public function lihatPeserta(Ekstrakurikuler $ekstrakurikuler): View
    {
        $user = Auth::user();
        // Opsional: Tambahkan pengecekan apakah PJ yang login adalah PJ dari ekstrakurikuler ini
        if ($user->nim !== $ekstrakurikuler->id_pj) {
            abort(403, 'Anda tidak berhak mengakses daftar peserta ekstrakurikuler ini.');
        }

        // Eager load data peserta (warga) beserta detail yang dibutuhkan
        // Asumsi relasi di model Ekstrakurikuler adalah 'pesertas()'
        $ekstrakurikuler->load(['pesertas' => function ($query) {
            $query->select('pengguna.nim', 'pengguna.nama', 'pengguna.email', 'pengguna.telepon') // Pilih kolom yang ingin ditampilkan
                  ->orderBy('pengguna.nama', 'asc'); // Urutkan berdasarkan nama peserta
        }]);

        return view('pj.ekstrakurikuler.peserta', [
            'ekskul' => $ekstrakurikuler,
            'listPeserta' => $ekstrakurikuler->pesertas,
        ]);
    }
}