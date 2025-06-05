<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler; // Pastikan model Ekstrakurikuler di-import
use Illuminate\Http\Request;    // Bisa dihapus jika tidak digunakan di method show
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan info pengguna yang login

class EkstrakurikulerDetailController extends Controller
{
    /**
     * Menampilkan halaman detail untuk ekstrakurikuler yang dipilih.
     *
     * @param  \App\Models\Ekstrakurikuler  $ekstrakurikuler  Instance model yang di-resolve oleh Route Model Binding
     * @return \Illuminate\View\View
     */
    public function show(Ekstrakurikuler $ekstrakurikuler): View
    {
        // Berkat Route Model Binding, Laravel sudah otomatis mengambil record Ekstrakurikuler
        // dari database berdasarkan parameter di URL (misalnya ID atau slug jika Anda mengkonfigurasinya).
        // Jadi, $ekstrakurikuler di sini sudah berisi objek Ekstrakurikuler yang sesuai.

        // Jika Anda ingin memuat relasi lain dari ekstrakurikuler ini (misalnya daftar pemateri),
        // Anda bisa melakukannya di sini:
        // $ekstrakurikuler->load('pemateri'); // Asumsi ada relasi 'pemateri' di model Ekstrakurikuler

        // Kita juga bisa cek status partisipasi pengguna yang sedang login terhadap ekskul ini
        /** @var \App\Models\Pengguna|null $currentUser */
        $currentUser = Auth::user();
        $isMengikutiSebagaiUtama = false;

        if ($currentUser && $currentUser->id_ektrakulikuler == $ekstrakurikuler->id_ekstrakulikuler) {
            $isMengikutiSebagaiUtama = true;
        }

        // Kirim data ekstrakurikuler dan status partisipasi ke view
        return view('ekstrakurikuler.detail', [
            'ekskul' => $ekstrakurikuler,
            'isMengikutiSebagaiUtama' => $isMengikutiSebagaiUtama,
            // 'user' => $currentUser, // Kirim juga jika diperlukan di view
        ]);
    }
}