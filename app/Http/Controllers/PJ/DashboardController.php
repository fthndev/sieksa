<?php

namespace App\Http\Controllers\PJ; // Pastikan namespace sesuai dengan lokasi file

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // Bisa dihapus jika tidak dipakai
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Ekstrakurikuler; // Kita akan gunakan untuk statistik
use App\Models\Pengguna;       // Kita akan gunakan untuk statistik

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk PJ (Penanggung Jawab).
     */
    public function index(): View
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user(); // Mendapatkan instance Pengguna (PJ) yang sedang login

        $listEkstrakurikulerDikelola = collect(); // Inisialisasi sebagai koleksi kosong
        $statistik = [
            'totalEkstrakurikuler' => 0,
            'totalWarga' => 0,
            'totalMusahil' => 0,
        ];

        if ($user) {
            // Mengambil semua ekstrakurikuler yang dikelola oleh PJ ini,
            // dan juga mengambil (eager load) data pesertanya untuk setiap ekstrakurikuler.
            // Serta mengurutkan ekstrakurikuler berdasarkan nama.
            $listEkstrakurikulerDikelola = $user->ekstrakurikulerDikelola()
                                              ->with(['pesertas' => function ($query) {
                                                  // Hanya ambil kolom yang dibutuhkan dari peserta
                                                  // Tambahkan 'pengguna.' untuk menghindari ambiguitas jika ada join kompleks di masa depan
                                                  $query->select('pengguna.nim', 'pengguna.nama', 'pengguna.email', 'pengguna.id_ekstrakurikuler');
                                              }])
                                              ->orderBy('nama_ekstra', 'asc')
                                              ->get();

            // Mengambil data untuk kartu statistik (contoh)
            // Jumlah ekstrakurikuler yang dikelola PJ ini
            $statistik['totalEkstrakurikuler'] = $listEkstrakurikulerDikelola->count();

            // Contoh mengambil total warga dan musahil secara keseluruhan (bisa disesuaikan)
            // Jika PJ hanya boleh melihat statistik terkait ekskul yang dia kelola, logikanya akan lebih kompleks
            $statistik['totalWarga'] = Pengguna::where('role', 'warga')->count();
            $statistik['totalMusahil'] = Pengguna::where('role', 'musahil')->count();

        }

        // Mengirim data ke view dashboard PJ
        return view('pj.dashboard', [
            'user' => $user,
            'listEkstrakurikulerDikelola' => $listEkstrakurikulerDikelola,
            'statistik' => $statistik, // Kirim data statistik ke view
        ]);
    }
    public function updateJadwal(Request $request, $id)
{
    $request->validate([
        'hari' => 'required|string',
        'jam' => 'required',
    ]);

    $ekskul = Ekstrakurikuler::findOrFail($id);
    $ekskul->hari = $request->hari;
    $ekskul->jam = $request->jam;
    $ekskul->save();

    return back()->with('status', 'Jadwal berhasil diperbarui!');
}

    // Anda bisa menambahkan method lain di sini untuk aksi-aksi spesifik PJ
    // Misalnya:
    // public function lihatDetailPeserta(Pengguna $warga) { /* ... */ }
    // public function setujuiKegiatan(Ekstrakurikuler $ekskul) { /* ... */ }
}