<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Import controller untuk dashboard (umum dan per role)
use App\Http\Controllers\DashboardController; // Controller umum untuk /dashboard awal
use App\Http\Controllers\Warga\DashboardController as WargaDashboardController;
use App\Http\Controllers\Musahil\DashboardController as MusahilDashboardController;
use App\Http\Controllers\Musahil\ListWargaDidampingiController;
use App\Http\Controllers\PJ\DashboardController as PjDashboardController;
use App\Http\Controllers\EkstrakurikulerDetailController; // <-- TAMBAHKAN IMPORT INI

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
            // Route lain khusus warga
        });

    // Dashboard untuk Musahil
    Route::middleware('role:musahil')
        ->prefix('musahil')
        ->name('musahil.')
        ->group(function () {
            Route::get('/dashboard', [MusahilDashboardController::class, 'index'])->name('dashboard');
            Route::get('/list-warga', [ListWargaDidampingiController::class, 'index'])->name('list-warga');
            // Route lain khusus musahil
        });

    // Dashboard untuk PJ (Penanggung Jawab)
    Route::middleware('role:pj')
        ->prefix('pj')
        ->name('pj.')
        ->group(function () {
            Route::get('/dashboard', [PjDashboardController::class, 'index'])->name('dashboard');

            // RUTE UNTUK MANAJEMEN EKSTRAKURIKULER OLEH PJ
            Route::get('/ekstrakurikuler/create', [PJEkstrakurikulerController::class, 'create'])->name('ekstrakurikuler.create'); // <-- INI RUTE YANG ANDA BUTUHKAN
            Route::post('/ekstrakurikuler', [PJEkstrakurikulerController::class, 'store'])->name('ekstrakurikuler.store');
            // Anda mungkin juga memerlukan rute untuk index, edit, update, destroy ekstrakurikuler di sini nanti
            // Route::get('/ekstrakurikuler', [PJEkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');
            // Route::get('/ekstrakurikuler/{ekstrakurikuler}/edit', [PJEkstrakurikulerController::class, 'edit'])->name('ekstrakurikuler.edit');
            // Route::put('/ekstrakurikuler/{ekstrakurikuler}', [PJEkstrakurikulerController::class, 'update'])->name('ekstrakurikuler.update');
            // Route::delete('/ekstrakurikuler/{ekstrakurikuler}', [PJEkstrakurikulerController::class, 'destroy'])->name('ekstrakurikuler.destroy');
        });

    // Rute Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Menampilkan Detail Ekstrakurikuler
    // Parameter {ekstrakurikuler} akan di-resolve menggunakan Route Model Binding ke model Ekstrakurikuler
    // Pastikan model Ekstrakurikuler Anda sudah memiliki method getRouteKeyName() jika PK bukan 'id'
    // atau gunakan binding eksplisit: {ekstrakurikuler:id_ekstrakulikuler}
    Route::get('/ekstrakurikuler/{ekstrakurikuler}', [EkstrakurikulerDetailController::class, 'show'])
         ->name('ekstrakurikuler.detail'); // Nama route yang kita gunakan di view dashboard warga

});

// Route otentikasi dari Breeze/Fortify (login, register, forgot password, dll.)
require __DIR__.'/auth.php';