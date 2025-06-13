<?php
use Illuminate\Support\Facades\Route;
use App\Models\Ekstrakurikuler;
use App\Models\Pengguna;

// --- Import Semua Controller yang Dibutuhkan ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EkstrakurikulerDetailController; // Controller umum untuk lihat detail
use App\Http\Controllers\AbsensiController; // Controller utama untuk semua logika absensi

// Controller spesifik untuk setiap role
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Musahil\DashboardController as MusahilDashboardController;
use App\Http\Controllers\PJ\DashboardController as PjDashboardController;
use App\Http\Controllers\PJ\EkstrakurikulerController as PJEkstrakurikulerController;
use App\Http\Controllers\Musahil\ListWargaDidampingiController;
use App\Http\Controllers\Warga\EkstrakurikulerDetailController as WargaEkstrakurikulerController;
use App\Http\Controllers\Musahil\EkstrakurikulerDetailController as MusahilEkstrakurikulerDetailController;
use App\Http\Controllers\PJ\ListWargaDidampingPj as ListWargaDidampingiControllerPJ;

// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------

Route::get('/', function () {
    return view('welcome');
});

// Titik masuk utama setelah login
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Grup route utama yang memerlukan autentikasi
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Grup untuk Warga (rute lama dipertahankan, absensi diubah) ---
    Route::middleware('role:warga')
        ->prefix('warga')
        ->name('warga.')
        ->group(function () {
            Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');
            Route::get('/ekstrakurikuler/{ekstrakurikuler}', [WargaEkstrakurikulerController::class, 'show'])->name('detail_ekstra');
            Route::get('/daftar_orang/{ekskul}', function (Ekstrakurikuler $ekskul){
                return view('warga.daftar_orang', ['ekskul' => $ekskul, 'orang' => $ekskul->pesertas]);
            })->name('daftar_orang_ekstra');
            // Route::get('/absensi/{pengguna:nim}', ...) // <-- Rute absensi lama dihapus
            Route::get('pendaftaran_ekstra/{ekskul}', [WargaEkstrakurikulerController::class, 'tambahekstra'])->name('pendaftaran_ekstra');
            Route::get('/absensi', [AbsensiController::class, 'tampilkanHalamanAbsensiWarga'])->name('absensi_ekstra');
        });

    // --- Grup untuk Musahil (rute lama dipertahankan, absensi diubah) ---
    Route::middleware('role:musahil')
        ->prefix('musahil')
        ->name('musahil.')
        ->group(function () {
            Route::get('/dashboard', [MusahilDashboardController::class, 'index'])->name('dashboard');
            Route::get('/list-warga', [ListWargaDidampingiController::class, 'index'])->name('list-warga');
            Route::get('/absensi', [AbsensiController::class, 'tampilkanHalamanAbsensiWarga'])->name('absensi_ekstra');
            Route::get('/ekstrakurikuler/{ekstrakurikuler}', [MusahilEkstrakurikulerDetailController::class, 'show'])
              ->name('detail_ekstra');
            Route::get('/daftar_orang/{ekskul}', function (Ekstrakurikuler $ekskul){
                return view('musahil.daftar_orang', ['ekskul' => $ekskul, 'orang' => $ekskul -> pesertas]);
            }) ->name('daftar_orang_ekstra');
            Route::get('pendaftaran_ekstra/{ekskul}', [MusahilEkstrakurikulerDetailController::class, 'tambahekstra'])
            ->name('pendaftaran_ekstra');
            // Rute-rute lain yang sudah Anda miliki untuk Musahil ...
            // Route::get('/absensi/{pengguna:nim}', ...) // <-- Rute absensi lama dihapus
        });

    // --- Grup untuk Penanggung Jawab (PJ) ---
    Route::middleware('role:pj')
        ->prefix('pj')
        ->name('pj.')
        ->group(function () {
            Route::get('/dashboard', [PjDashboardController::class, 'index'])->name('dashboard');
            Route::get("/ekstrakurikuler/peserta/{id}", [PJEkstrakurikulerController::class, 'lihatpeserta'])->name('lihatpeserta');
            // Route::get('/ekstrakurikuler/absensi/{id}', ...) // <-- Rute absensi lama dihapus dan diganti dengan yang baru di bawah


            // PENAMBAHAN: Rute untuk PJ mengelola absensi
            Route::get('/absensi', [AbsensiController::class, 'tampilkanHalamanManajemenPJ'])->name('absensi.index');
            Route::get('absensi/kelola', [AbsensiController::class, 'kelola'])->name('absensi.kelola');
            Route::get('/absensi/{absensi}/detail', [AbsensiController::class, 'tampilkanDetailSesi'])->name('absensi.detail');
            Route::post('/absensi/{absensi}/regenerate-qr', [AbsensiController::class, 'regenerateQrCode'])->name('absensi.regenerate_qr');
            Route::post('/absensi/{absensi}/toggle-status', [AbsensiController::class, 'toggleStatus'])->name('absensi.toggle_status');
            Route::patch('/detail-absensi/{detailAbsensi}/{pengguna}/update-status', [AbsensiController::class, 'updateStatusKehadiran'])->name('absensi.update_status');
            Route::post('/ekstrakurikuler/{ekstrakurikuler}/mulai-sesi-qr', [AbsensiController::class, 'mulaiSesiDanTampilkanQR'])->name('absensi.mulai_sesi_qr');
            Route::get('/list-warga', [ListWargaDidampingiControllerPJ::class, 'index'])->name('list-warga');
            // routes/web.php
            Route::post('/pj/absensi/{id}/upload', [AbsensiController::class, 'upload'])->name('absensi.upload');
            Route::put('/pj/dashboard/{id}', [PjDashboardController::class, 'updateJadwal'])->name('dashboards');
            // Rute CRUD Ekstrakurikuler Anda yang lain
            Route::get('/ekstrakurikuler/{ekstrakurikuler}', [EkstrakurikulerDetailController::class, 'show'])
            ->name('detail_ekstra');
            Route::get('/daftar_orang/{ekskul}', function (Ekstrakurikuler $ekskul){
              return view('pj.daftar_orang', ['ekskul' => $ekskul, 'orang' => $ekskul -> pesertas]);
                }) ->name('daftar_orang_ekstra');
            });

    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/password', [ProfileController::class, 'update_pw'])->name('pw.update');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    // PENAMBAHAN: Rute untuk Warga & Musahil membuka halaman scanner
    Route::middleware('role:warga,musahil')->group(function () {
        Route::get('/absensi/scan', [AbsensiController::class, 'tampilkanHalamanScan'])->name('absensi.scan');
    });
});
// --- RUTE UNTUK MEMPROSES HASIL SCAN QR ---


// PENAMBAHAN: Rute untuk memproses hasil scan QR
Route::middleware(['auth', 'signed'])
     ->get('/absensi/hadir/{absensi}', [AbsensiController::class, 'catatKehadiran'])
     ->name('absensi.hadir');

// Route otentikasi dari Breeze/Fortify
require __DIR__.'/auth.php';