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
use App\Http\Controllers\Admin\EkstrakurikulerController as AdminEkstrakurikulerController;
use App\Http\Controllers\Admin\UserController as UserController;
use App\Http\Controllers\Admin\PenggunaController as PenggunaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AbsensiEkstra;
use App\Models\Absensi;
use App\Http\Controllers\Admin\MateriController;

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
            Route::get('/absensi', [AbsensiController::class, 'tampilkanHalamanAbsensiMusahil'])->name('absensi_ekstra');
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
            Route::get('/absensi/detail/{absensi}/{ekstra}', [AbsensiController::class, 'return_view'])->name('detail_absensi_table');
            Route::get('/absensi/detail/{absensi}/{ekstra}/pdf', [AbsensiController::class, 'return_view_pdf'])->name('detail_absensi_table_pdf');
            Route::get('/absensi/detail/{absensi}/{ekstra}/download', [AbsensiController::class, 'excel_download'])->name('download_excel');
            });
            
            // routes/web.phproute('pj.detail_absensi_table
    Route::middleware('role:admin')
    ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::get('/ekstrakurikuler', [AdminEkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');
                // Halaman untuk menampilkan & mengelola anggota
            Route::get('/ekstrakurikuler/{ekstrakurikuler}/kelola-anggota', [AdminEkstrakurikulerController::class, 'showMembers'])->name('ekstrakurikuler.members');
            Route::post('/{ekstrakurikuler}/tambah-anggota', [AdminEkstrakurikulerController::class, 'addMember'])->name('ekstrakurikuler.members.add');
            Route::post('/admin/ekstrakurikuler', [AdminEkstrakurikulerController::class, 'store'])->name('ekstrakurikuler.store');
            Route::put('/admin/ekstrakurikuler/{ekskul}/update', [AdminEkstrakurikulerController::class, 'update'])->name('ekstrakurikuler.update');

            // Aksi untuk mengeluarkan anggota dari ekskul
            Route::delete('/ekstrakurikuler/members/{ekstrakurikuler}/{pengguna}/remove', [AdminEkstrakurikulerController::class, 'removeMember'])->name('ekstrakurikuler.members.remove');
            Route::delete('/ekstrakurikuler//members/{ekskul}/remove-all', [AdminEkstrakurikulerController::class, 'removeAllMembers'])->name('ekstrakurikuler.members.removeAll');

            // Aksi untuk mempromosikan anggota menjadi PJ
            Route::post('/ekstrakurikuler/{ekstrakurikuler}/assign-pj', [AdminEkstrakurikulerController::class, 'assignPj'])->name('ekstrakurikuler.members.assign');

            // Aksi untuk mencabut status PJ
            Route::post('/ekstrakurikuler/{ekstrakurikuler}/revoke-pj', [AdminEkstrakurikulerController::class, 'revokePj'])->name('ekstrakurikuler.members.revoke');
            // Tambahkan rute lain untuk manajemen oleh admin di sini nanti
            // Contoh: Route::resource('/users', AdminUserController::class);
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::delete('/users/{pengguna}', [UserController::class, 'destroy'])->name('users.destroy');
                    // Rute untuk impor dan CRUD Pengguna
            Route::post('/pengguna/import', [AdminPenggunaController::class, 'import'])->name('pengguna.import');
            Route::resource('/pengguna', PenggunaController::class)->except(['show']);
            Route::get('/daftar_absensi_ekstra', [AbsensiEkstra::class, 'index'])->name('daftar_absensi_ekstra');
            Route::get('/daftar_absensi_ekstra/{ekstrakurikuler:id_ekstrakurikuler}', [AbsensiEkstra::class, 'show_members'])->name('kelola_absensi_member');
            Route::get('/kelola_data_absensi/{id}', [AbsensiEkstra::class, 'lihat_detail_absensi'])->name('list_absensi_member');
            Route::delete('/list_absensi_member/{id}', [AbsensiEkstra::class, 'hapus_absensi'])->name('hapus_absensi_peserta');
            Route::patch('/list_absensi_member/{detailAbsensi}/{pengguna}', [AbsensiEkstra::class, 'updateStatusKehadiran_admin'])->name('absensi_update_status_admin');
            Route::get('/list_absensi_member/{id}', [AbsensiEkstra::class, 'show_members_detail'])->name('kelola_absensi_member_detail');
            Route::delete('/absensi/{id}/clear', [AbsensiEkstra::class, 'clear_all_absensi'])->name('clear_absensi_peserta');
            Route::get('/daftar_materi', [MateriController::class, 'show'])->name('daftar_materi_ekstra');
            Route::delete('/daftar_materi/{id}', [MateriController::class, 'hapus_materi'])->name('hapus_materi');
            Route::delete('/daftar_materi', [MateriController::class, 'clear_all_materi'])->name('clear_materi');

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