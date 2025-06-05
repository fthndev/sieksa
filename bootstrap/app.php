<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // Pastikan ini di-import jika belum

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan alias untuk route middleware Anda di sini
        $middleware->alias([
            // Middleware bawaan Breeze/Fortify mungkin sudah otomatis terdaftar
            // atau Anda bisa menambahkannya di sini jika diperlukan oleh aplikasi Anda.
            // Contoh:
            // 'auth' => \App\Http\Middleware\Authenticate::class,
            // 'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Jika menggunakan verifikasi email

            // 👇 INI YANG PALING PENTING UNTUK DITAMBAHKAN 👇
            'role' => \App\Http\Middleware\EnsureUserHasRole::class,
        ]);

        // Anda juga bisa mendaftarkan global middleware atau group middleware di sini
        // Contoh:
        // $middleware->web(append: [
        // \App\Http\Middleware\ExampleMiddleware::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Konfigurasi penanganan exception
        // Contoh:
        // $exceptions->dontReport([
        //     \App\Exceptions\MyCustomException::class,
        // ]);
    })->create();

// Baris di bawah ini mendaftarkan FortifyServiceProvider secara eksplisit.
// Ini biasanya tidak diperlukan jika FortifyServiceProvider sudah terdaftar
// di array 'providers' pada file config/app.php (yang merupakan cara standar).
// Namun, jika Fortify Anda berfungsi dengan ini, Anda bisa membiarkannya.
// Jika Anda mengalami masalah "double registration" atau provider tidak termuat,
// periksa juga config/app.php Anda.
// Untuk error "Target class [role] does not exist", baris ini tidak secara langsung menjadi penyebab.
// $app->register(App\Providers\FortifyServiceProvider::class); // <-- Bagian ini dari kode Anda sebelumnya

// Kode `$app = Application::configure...->create();` di atas sudah mengembalikan instance $app.
// Jadi, jika Anda perlu mendaftarkan provider secara manual di sini (yang jarang untuk L11),
// caranya akan sedikit berbeda dan biasanya dilakukan melalui method `->withProviders()`.
// Untuk Fortify, pastikan ia terdaftar di config/app.php atau otomatis ditemukan oleh Laravel.

// Kode yang Anda berikan:
// $app = Application::configure...->create();
// $app->register(App\Providers\FortifyServiceProvider::class); <-- ini akan mencoba mendaftarkan setelah $app dibuat
// return $app;
// Seharusnya:
// $application = Application::configure...
//    ->withProviders([...]) // Cara L11 untuk provider tambahan jika tidak auto-discover atau di config/app.php
//    ->create();
// return $application;
// Namun, untuk FortifyServiceProvider, biasanya sudah cukup jika ada di config/app.php.