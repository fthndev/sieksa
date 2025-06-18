<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\DetailAbsensi;
use App\Models\Ekstrakurikuler;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    // =======================================================
    // == BAGIAN UNTUK PENANGGUNG JAWAB (PJ)
    // =======================================================

    /**
     * Menampilkan halaman manajemen absensi untuk PJ.
     */
    public function tampilkanHalamanManajemenPJ(): View
    {
        /** @var \App\Models\Pengguna $pj */
        $pj = Auth::user();

        // Ambil semua ekskul yang dikelola oleh PJ ini,
        // dan langsung muat (eager load) relasi histori absensinya untuk setiap ekskul.
        $listEkstrakurikulerDikelola = $pj->ekstrakurikulerDikelola()
            ->with(['absensi' => function ($query) {
                // Urutkan sesi absensi per ekstrakurikuler, yang terbaru di atas
                $query->orderBy('pertemuan', 'desc')
                      ->withCount('detailAbsensi as jumlah_hadir'); // Hitung jumlah hadir
            }])
            ->orderBy('nama_ekstra')
            ->get();

        return view('pj.absensi.index', [ // Kita akan buat view baru ini
            'user' => $pj,
            'listEkstrakurikulerDikelola' => $listEkstrakurikulerDikelola,
        ]);
    }
   public function tampilkanDetailSesi(Absensi $absensi): View
    {
        // Menggunakan Eager Loading untuk mengambil semua data terkait dalam query yang efisien
        $absensi->load([
            // Muat relasi 'ekstrakurikuler' dari sesi absensi ini
            'ekstrakurikuler',
            // Muat relasi 'detailAbsensi', dan untuk setiap detail, muat juga relasi 'pengguna' nya
            'detailabsensi.pengguna' => function ($query) {
                // Urutkan daftar peserta berdasarkan nama secara ascending (A-Z)
                $query->orderBy('nama', 'asc');
            }
        ]);
        $penggunaList = Pengguna::where('role', 'warga', 'musahil')
        ->where('id_ekstrakurikuler', $absensi->id_ekstrakurikuler)
        ->whereNotIn('nim', $absensi->detailAbsensi->pluck('id_pengguna'))
        ->get();

        // --- Logika Otorisasi yang Lebih Aman ---

        // 1. Cek dulu apakah sesi absensi ini terhubung dengan ekstrakurikuler yang valid.
        if (!$absensi->ekstrakurikuler) {
            // Jika tidak, tampilkan halaman Not Found yang sesuai.
            abort(404, 'Data Ekstrakurikuler untuk sesi absensi ini tidak ditemukan.');
        }

        // 2. Setelah yakin relasinya ada, baru cek apakah PJ yang login berhak mengakses.
        if (Auth::user()->nim !== $absensi->ekstrakurikuler->id_pj) {
            abort(403, 'Akses Ditolak. Anda bukan Penanggung Jawab untuk ekstrakurikuler ini.');
        }

        // Kirim data sesi absensi (yang sudah berisi semua relasi) ke view
        return view('pj.absensi.detail', compact('absensi', 'penggunaList'));
    }

    /**
     * Membuat sesi absensi baru dan mengembalikan URL untuk QR Code.
     */
    public function mulaiSesiDanTampilkanQR(Ekstrakurikuler $ekstrakurikuler, Request $request): JsonResponse
    {
        if (Auth::user()->nim !== $ekstrakurikuler->id_pj) {
            abort(403);
        }

        $validated = $request->validate([
            'pertemuan' => ['required', 'integer', 'min:1'],
            'materi' => ['required', 'string', 'max:500'],
        ]);

        $sesiAbsensi = Absensi::create([
            'id_ekstrakurikuler' => $ekstrakurikuler->id_ekstrakurikuler,
            'tanggal' => now()->toDateString(),
            'pertemuan' => $validated['pertemuan'],
            'materi' => $validated['materi'],
        ]);

        // Buat URL yang aman dan berbatas waktu (misalnya, 10 menit)
        $urlAbsensi = URL::temporarySignedRoute(
            'absensi.hadir',
            now()->addMinutes(10),
            ['absensi' => $sesiAbsensi]
        );

        return response()->json(['url' => $urlAbsensi]);
    }
    public function regenerateQrCode(Absensi $absensi): JsonResponse
    {
        // Otorisasi & Logika... (seperti yang kita diskusikan sebelumnya)
        // ...
        $newUrl = URL::temporarySignedRoute('absensi.hadir', now()->addMinutes(10), ['absensi' => $absensi]);
        return response()->json(['url' => $newUrl]);
    }

    public function toggleStatus(Absensi $absensi): RedirectResponse
    {
        // Otorisasi...
        if (Auth::user()->nim !== $absensi->ekstrakurikuler->id_pj) { abort(403); }

        // Ubah status
        $absensi->status = ($absensi->status == 'open') ? 'closed' : 'open';
        $absensi->save();

        return back()->with('status', 'Status sesi absensi berhasil diubah!');
    }
    public function updateStatusKehadiran(Request $request, DetailAbsensi $detailAbsensi, Pengguna $pengguna): RedirectResponse
    {
        // Otorisasi: Pastikan PJ yang login adalah PJ dari ekstrakurikuler sesi ini
        if (Auth::user()->nim !== $detailAbsensi->absensi->ekstrakurikuler->id_pj) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah data ini.');
        }

        $validated = $request->validate([
            'status' => ['required', 'string', \Illuminate\Validation\Rule::in(['hadir', 'izin', 'sakit', 'alpha', 'absen'])],
        ]);

        if ($detailAbsensi->id_pengguna === $pengguna->nim) {
            $detailAbsensi->update([
                'status' => $request->input('status'),
        ]);
}

        return back()->with('status', 'Status kehadiran berhasil diperbarui!');
    }

    // =======================================================
    // == BAGIAN UNTUK WARGA & MUSAHIL
    // =======================================================

    /**
     * Menampilkan halaman absensi untuk Warga, berisi tombol scan dan histori.
     */
      public function tampilkanHalamanAbsensiWarga(): View
    {
        // 1. Ambil pengguna yang sedang login.
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();

        // 2. Dapatkan ekstrakurikuler utama yang diikuti oleh pengguna ini.
        $ekskul = $user->ekstrakurikuler; // Menggunakan relasi ekstrakurikuler() di model Pengguna

        // Inisialisasi histori sebagai koleksi kosong untuk menghindari error di view
        $historiAbsensiPribadi = collect();

        // 3. Jika pengguna terdaftar di sebuah ekstrakurikuler utama...
        if ($ekskul) {
            // ...ambil semua histori absensi PRIBADI pengguna ini HANYA untuk ekstrakurikuler tersebut.
            $historiAbsensiPribadi = DetailAbsensi::where('id_pengguna', $user->nim)
                // Filter hanya untuk sesi absensi yang termasuk dalam ekskul utama pengguna
                ->whereHas('absensi', function ($query) use ($ekskul) {
                    $query->where('id_ekstrakurikuler', $ekskul->id_ekstrakurikuler);
                })
                ->with('absensi') // Eager load data sesi absensi (pertemuan, tanggal, materi)
                ->join('absensi', 'detail_absensi.id_absensi', '=', 'absensi.id_absensi')
                ->orderBy('absensi.tanggal', 'desc')
                ->orderBy('absensi.pertemuan', 'desc')
                ->select('detail_absensi.*') // Pilih semua kolom dari detail_absensi untuk menghindari ambiguitas
                ->get();
        }

        // 4. Kirim semua data yang dibutuhkan ke view 'warga.absensi'
        return view('warga.absensi', [
            'user' => $user,
            'ekskul' => $ekskul, // Bisa null jika user tidak ikut ekskul utama
            'historiAbsensiPribadi' => $historiAbsensiPribadi,
            'pengguna' => $user, // Menambahkan variabel 'pengguna' karena view Anda mungkin membutuhkannya
        ]);
    }
    /**
     * Menampilkan halaman absensi untuk Musahil, berisi tombol scan dan histori.
     */
    public function tampilkanHalamanAbsensiMusahil(): View
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user();
        $ekskul = $user->ekstrakurikuler;

        // Ambil histori absensi PRIBADI untuk musahil ini di semua ekskul yang mungkin dia hadiri
        $historiAbsensiPribadi = DetailAbsensi::where('id_pengguna', $user->nim)
                                ->with('absensi.ekstrakurikuler') // Eager load sampai ke nama ekstrakurikulernya
                                ->join('absensi', 'detail_absensi.id_absensi', '=', 'absensi.id_absensi')
                                ->orderBy('absensi.tanggal', 'desc')
                                ->orderBy('absensi.pertemuan', 'desc')
                                ->select('detail_absensi.*')
                                ->get();

        return view('musahil.absensi', compact('user', 'historiAbsensiPribadi', 'ekskul'));
    }

    /**
     * Menampilkan halaman dengan kamera scanner untuk Warga dan Musahil.
     */
    public function tampilkanHalamanScan(): View
    {
        return view('absensi.scan');
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file_materi' => 'required|file|mimes:pdf,docx,doc,pptx|max:2048',
        ]);
    
        $absensi = Absensi::findOrFail($id);
    
        // Simpan file ke storage/app/public/materi/
        $path = $request->file('file_materi')->store('materi', 'public');
    
        // Update path file ke kolom 'materi'
        $absensi->path = $path;
        $absensi->save();
    
        return back()->with('status', 'File materi berhasil diunggah.');
    }
    

    /**
     * Mencatat kehadiran setelah scan QR.
     */
    public function catatKehadiran(Absensi $absensi, Request $request): JsonResponse|RedirectResponse
    {
        /** @var \App\Models\Pengguna $user */
        $user = Auth::user(); // User sudah pasti ada karena middleware 'auth'

        // Pengecekan otorisasi (apakah pengguna berhak absen di ekskul ini)
        $isPesertaWarga = $user->hasRole('warga') && ($user->id_ekstrakurikuler == $absensi->id_ekstrakurikuler);
        $isMusahil = $user->hasRole('musahil'); // Musahil diasumsikan boleh ikut sesi manapun
        if (!$isPesertaWarga && !$isMusahil) {
            $errorMessage = 'Anda tidak terdaftar sebagai peserta atau musahil di ekstrakurikuler ini.';
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => $errorMessage], 403)
                : back()->with('error', $errorMessage);
        }

        // Catat kehadiran menggunakan firstOrCreate untuk menghindari duplikasi
        DetailAbsensi::firstOrCreate(
            [
                'id_absensi' => $absensi->id_absensi,
                'id_pengguna' => $user->nim,
            ],
            [
                'status' => 'hadir',
                'note' => 'Absensi via QR Code.',
            ]
        );

        $message = 'Kehadiran Anda untuk ' . $absensi->ekstrakurikuler->nama_ekstra . ' berhasil dicatat!';

        // --- LOGIKA RESPON PINTAR ---
        if ($request->wantsJson()) {
            // Jika request datang dari scanner AJAX kita, kirim JSON
            return response()->json(['success' => true, 'message' => $message]);
        }

        // Jika tidak, ini adalah request browser biasa (setelah login atau sudah login),
        // maka arahkan ke dashboard yang sesuai dengan notifikasi sukses.
        $roleDashboard = $user->role . '.dashboard';
        return redirect()->route($roleDashboard)->with('success', $message);
    }

    public function return_view(Absensi $absensi, Ekstrakurikuler $ekstra): View
    {   

    $user = Auth::user();
    $parent_absensi = DB::table('absensi')
       ->where('id_absensi', $absensi->id_absensi)
       ->get()->first();
    $peserta_ekstra = DB::table('Pengguna')
       ->where('id_ekstrakurikuler', $ekstra->id_ekstrakurikuler)
       ->whereIn('role', ['musahil', 'warga'])
       ->get();

        return view('pj.absensi.absensi_excel', [
            'ekstra' => $peserta_ekstra,
            'data_absensi' => $parent_absensi,
            'data_pj' => $user
        ]);
    }
    public function return_view_pdf(Absensi $absensi, Ekstrakurikuler $ekstra): View
    {   

    $user = Auth::user();
    $parent_absensi = DB::table('absensi')
       ->where('id_absensi', $absensi->id_absensi)
       ->get()->first();
    $peserta_ekstra = DB::table('Pengguna')
       ->where('id_ekstrakurikuler', $ekstra->id_ekstrakurikuler)
       ->whereIn('role', ['musahil', 'warga'])
       ->get();

        return view('pj.absensi.absensi_pdf', [
            'ekstra' => $peserta_ekstra,
            'data_absensi' => $parent_absensi,
            'data_pj' => $user
        ]);
    }

    public function excel_download(Absensi $absensi, Ekstrakurikuler $ekstra)
    {   

    $user = Auth::user();
    $parent_absensi = DB::table('absensi')
       ->where('id_absensi', $absensi->id_absensi)
       ->get()->first();
    $peserta_ekstra = DB::table('Pengguna')
       ->where('id_ekstrakurikuler', $ekstra->id_ekstrakurikuler)
       ->whereIn('role', ['musahil', 'warga'])
       ->get();

    
    $filename = 'laporan_absensi_' . $parent_absensi->pertemuan . '.xls';
    return response()->view('pj.absensi.download_absensi', [
        'ekstra' => $peserta_ekstra,
        'data_absensi' => $parent_absensi,
        'data_pj' => $user
    ])->header('Content-Type', 'application/vnd.ms-excel')
    ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
    public function storeDetail(Request $request, $id)
{   
    $request->validate([
        'pengguna_id' => 'required|exists:pengguna,nim',
        'status' => 'required|in:izin,sakit,alpha',
    ]);
    
    DetailAbsensi::create([
        'id_absensi' => $id,
        'id_pengguna' => $request->pengguna_id,
        'status' => $request->status,
    ]);

    return redirect()->back()->with('success', 'Data absensi berhasil ditambahkan.');
}

}