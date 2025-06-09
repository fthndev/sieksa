<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Import controller untuk dashboard (umum dan per role)
use App\Http\Controllers\DashboardController; // Controller umum untuk /dashboard awal
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Warga\EkstrakurikulerDetailController as WargaEkstrakurikulerController;
use App\Http\Controllers\Musahil\DashboardController as MusahilDashboardController;
use App\Http\Controllers\PJ\DashboardController as PjDashboardController;
use App\Http\Controllers\EkstrakurikulerDetailController; // <-- TAMBAHKAN IMPORT INI
use App\Http\Controllers\PJ\EkstrakurikulerController;
use App\Models\Ekstrakurikuler;
use App\Models\Pengguna;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome'); // Halaman selamat datang Anda
});

// Rute ini akan menjadi TITIK MASUK utama setelah login (jika HOME diarahkan ke 'dashboard').
// DashboardController@index akan melakukan redirect ke role-specific dashboard.
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified']) // 'verified' jika Anda menggunakan verifikasi email
    ->name('dashboard');


// Grup route utama yang memerlukan autentikasi (dan verifikasi email jika diaktifkan)
// untuk halaman-halaman spesifik setelah login dan redirect berdasarkan role.
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard untuk Warga
    Route::middleware('role:warga')
        ->prefix('warga')
        ->name('warga.')
        ->group(function () {
            Route::get('/dashboard', [WargaDashboardController::class, 'index'])->name('dashboard');
            // Route lain khusus warga\
            Route::get('/ekstrakurikuler/{ekstrakurikuler}', [WargaEkstrakurikulerController::class, 'show'])
              ->name('detail_ekstra');
            Route::get('/daftar_orang/{ekskul}', function (Ekstrakurikuler $ekskul){
                return view('warga.daftar_orang', ['ekskul' => $ekskul, 'orang' => $ekskul -> pesertas]);
            }) ->name('daftar_orang_ekstra');
            Route::get('/absensi/{pengguna:nim}', function(Pengguna $pengguna){
                return view('warga.absensi', ['pengguna' => $pengguna]);    
            }) ->name('absensi_ekstra');
            Route::get('pendaftaran_ekstra/{ekskul}', [WargaEkstrakurikulerController::class, 'tambahekstra'])
            ->name('pendaftaran_ekstra');
        });

    // Dashboard untuk Musahil
    Route::middleware('role:musahil')
        ->prefix('musahil')
        ->name('musahil.')
        ->group(function () {
            Route::get('/dashboard', [MusahilDashboardController::class, 'index'])->name('dashboard');
            // Route lain khusus musahil
        });

    // Dashboard untuk PJ (Penanggung Jawab)
    Route::middleware('role:pj')
        ->prefix('pj')
        ->name('pj.')
        ->group(function () {
            Route::get('/dashboard', [PjDashboardController::class, 'index'])->name('dashboard');
            // Route lain khusus pj
            // Contoh jika PJ bisa mengelola ekstrakurikuler:
            // Route::resource('ekstrakurikuler', PJEkstrakurikulerController::class); // ini contoh saja
        });

    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Menampilkan Detail Ekstrakurikuler
    // Parameter {ekstrakurikuler} akan di-resolve menggunakan Route Model Binding ke model Ekstrakurikuler
    // Pastikan model Ekstrakurikuler Anda sudah memiliki method getRouteKeyName() jika PK bukan 'id'
    // atau gunakan binding eksplisit: {ekstrakurikuler:id_ekstrakulikuler} // Nama route yang kita gunakan di view dashboard warga

});

// Route otentikasi dari Breeze/Fortify (login, register, forgot password, dll.)
require __DIR__.'/auth.php';