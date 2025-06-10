<?php

namespace App\Http\Controllers\Pj;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler; // Pastikan Anda memiliki model Ekstrakurikuler
use App\Models\Absensi; // Pastikan Anda memiliki model Absensi
use App\Models\Pengguna; // Impor model Pengguna
use Carbon\Carbon; // Untuk format tanggal jika diperlukan
use Illuminate\Contracts\View\View; // Impor View untuk type hinting
use Illuminate\Http\RedirectResponse; // Impor RedirectResponse untuk redirect
use Illuminate\Support\Facades\Storage; // Impor Storage untuk upload file

class AbsensiController extends Controller
{
    /**
     * Menampilkan daftar sesi absensi untuk ekstrakurikuler tertentu.
     * Ini digunakan untuk view yang menampilkan tabel pertemuan, tanggal, keterangan, dan file materi.
     *
     * @param int $id ID ekstrakurikuler
     * @return \Illuminate\Contracts\View\View
     */
    public function lihatabsensi($id): View
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);

        $listAbsensi = Absensi::where('id_ekstrakurikuler', $id)
                               ->orderBy('tanggal', 'desc') // Mengurutkan berdasarkan tanggal terbaru
                               ->get();

        return view('pj.ekstrakurikuler.absensi', compact('ekstrakurikuler', 'listAbsensi'));
    }

    /**
     * Menampilkan daftar peserta (pengguna) untuk ekstrakurikuler tertentu.
     * Method ini bisa digunakan sebagai halaman untuk melihat siapa saja yang terdaftar
     * dalam ekstrakurikuler tersebut, mungkin sebagai langkah awal sebelum mengambil absensi.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id ID ekstrakurikuler
     * @return \Illuminate\Contracts\View\View
     */
    public function lihatPeserta(Request $request, $id): View
    {
        $nim = $request->query('nim'); // Parameter opsional untuk filter berdasarkan NIM

        $listPeserta = Pengguna::where('id_ekstrakurikuler', $id)
            ->whereIn('role', ['warga', 'musahil'])
            ->when($nim, function ($query, $nim) {
                return $query->where('nim', $nim);
            })
            ->select('nim', 'nama', 'email', 'telepon', 'role')
            ->orderBy('nama', 'asc')
            ->get();

        $ekskul = Ekstrakurikuler::findOrFail($id);

        return view('pj.ekstrakurikuler.absensi', [
            'ekskul' => $ekskul,
            'listPeserta' => $listPeserta,
        ]);
    }

    /**
     * Menampilkan formulir untuk menambah data absensi pertemuan baru.
     *
     * @param int $id_ekstrakurikuler ID ekstrakurikuler terkait
     * @return \Illuminate\Contracts\View\View
     */
    public function tambahabsensi(int $id_ekstrakurikuler): View
    {
        // Pastikan ekstrakurikuler ada sebelum menampilkan form
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id_ekstrakurikuler);
        return view('pj.ekstrakurikuler.tambahabsensi', compact('ekstrakurikuler'));
    }

    /**
     * Menyimpan data absensi pertemuan baru ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id_ekstrakurikuler ID ekstrakurikuler terkait
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAbsensi(Request $request, int $id_ekstrakurikuler): RedirectResponse
    {
        // Validasi data yang masuk dari form
        $request->validate([
            'pertemuan' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:1000',
            'file_materi' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240', // Max 10MB
            // 'aktif' tidak perlu divalidasi jika diset default di sini
        ]);

        $filePath = null;
        // Tangani upload file materi jika ada
        if ($request->hasFile('file_materi')) {
            // Simpan file di storage/app/public/materi_absensi
            // Dan dapatkan path-nya untuk disimpan di database
            $filePath = $request->file('file_materi')->store('public/materi_absensi');
        }

        // Buat record absensi baru di database
        Absensi::create([
            'id_ekstrakurikuler' => $id_ekstrakurikuler,
            'pertemuan' => $request->pertemuan,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'file_materi' => $filePath ? Storage::url($filePath) : null, // Simpan URL publik file
            'aktif' => true, // Set default 'aktif' menjadi true saat absensi baru dibuat
        ]);

        // Redirect kembali ke halaman daftar absensi dengan pesan sukses
        return redirect()->route('pj.absensi', ['id' => $id_ekstrakurikuler])
                         ->with('success', 'Data absensi pertemuan berhasil ditambahkan!');
    }
}
