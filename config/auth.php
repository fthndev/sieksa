<?php

return [

    // ... (bagian 'defaults' dan 'guards' tetap sama, 'provider' => 'users' di guard web) ...
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users', // Ini akan merujuk ke provider 'users' di bawah
        ],
    ],

    'providers' => [
        'users' => [ // Kita tetap menggunakan key 'users' untuk provider utama
            'driver' => 'eloquent',         // <<< KEMBALIKAN KE CUSTOM PROVIDER ANDA
            'model' => App\Models\Pengguna::class, // <<< MODEL UTAMA ADALAH PENGGUNA
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users', // Ini akan menggunakan konfigurasi 'users' di atas
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];