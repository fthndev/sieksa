<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Ekstrakurikuler;   // Model Ekstrakurikuler
use App\Models\Pengguna;         // Model Pengguna (untuk type hint jika diperlukan)

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk warga.
     */
    public function index(): View
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();
        $ekstrakurikulerYangDiikuti = null;

        if (!$user) {
            // Ini seharusnya tidak akan terjadi jika rute dilindungi oleh middleware 'auth'
            abort(401, 'Pengguna tidak terautentikasi.');
        }

        // Mengambil nilai atribut 'id_ekstrakurikuler' dari objek Pengguna
        // Pastikan nama atribut ini ($user->id_ekstrakurikuler) ada dan di-load oleh Eloquent
        // dari kolom database yang benar di tabel 'pengguna'.
        $idEkstraDariUser = $user->id_ekstrakurikuler;

        if ($idEkstraDariUser) {
            // Memanggil relasi 'ekstrakurikuler' yang ada di model Pengguna
            // Relasi ini menggunakan foreign key 'id_ekstrakurikuler' (dari tabel pengguna)
            // dan owner key 'id_ekstrakurikuler' (dari tabel ekstrakurikuler)
            $ekstrakurikulerYangDiikuti = $user->ekstrakurikuler;
        }

        $semuaEkstrakurikuler = Ekstrakurikuler::orderBy('nama_ekstra', 'asc')->get();

        return view('warga.dashboard', [
            'user' => $user,
            'ekstrakurikulerYangDiikuti' => $ekstrakurikulerYangDiikuti,
            'semuaEkstrakurikuler' => $semuaEkstrakurikuler,
        ]);
    }
}