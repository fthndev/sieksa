<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Jika Anda menggunakan CDN Font Awesome, letakkan di sini atau di layout utama --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" /> --}}

    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-['Instrument_Sans'] text-slate-900 dark:text-slate-200 antialiased">
    <div class="min-h-screen flex flex-col md:flex-row bg-slate-50 dark:bg-slate-900">

        <div class="hidden md:flex md:w-1/2 lg:w-2/5 xl:w-[45%] bg-red-700 dark:bg-red-800 p-8 sm:p-12 text-white flex-col justify-center items-center relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-red-800 to-red-600 opacity-75 dark:opacity-50"></div>
            <div class="relative z-10 text-center w-full max-w-md">
                <a href="/">
                    <svg class="w-28 h-28 lg:w-32 lg:h-32 mx-auto mb-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                         <path fill-rule="evenodd" d="M9.504 1.132a1 1 0 01.992 0l6 3A1 1 0 0117 5v10a1 1 0 01-.5.866l-6 4a1 1 0 01-1 0l-6-4a1 1 0 01-.5-.866V5a1 1 0 01.504-.868l6-3zM10 4.618L4.802 7.5 10 10.382 15.198 7.5 10 4.618zM15 9.035l-4.223 2.815a1.002 1.002 0 01-1.554 0L5 9.035V14.5l5 3.333 5-3.333V9.035z" clip-rule="evenodd"></path>
                    </svg>
                </a>
                <h1 class="text-4xl lg:text-5xl font-bold mb-3 tracking-tight leading-tight">Bergabunglah dengan SIEKSA</h1>
                <p class="text-lg lg:text-xl font-light text-red-100 dark:text-red-200">
                    Buat akun untuk mulai mengelola dan mengikuti ekstrakurikuler.
                </p>
                <p class="mt-6 text-sm text-red-200 dark:text-red-300 opacity-90">
                    Proses pendaftaran cepat dan mudah. Mari kembangkan potensi bersama!
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 lg:w-3/5 xl:w-[55%] flex items-center justify-center p-6 sm:p-10 lg:p-12">
            <div class="w-full max-w-sm mx-auto">
                <div class="text-center md:text-left">
                     <a href="/" class="inline-block md:hidden mb-6 text-red-700 dark:text-red-500">
                         <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20">
                             <path fill-rule="evenodd" d="M9.504 1.132a1 1 0 01.992 0l6 3A1 1 0 0117 5v10a1 1 0 01-.5.866l-6 4a1 1 0 01-1 0l-6-4a1 1 0 01-.5-.866V5a1 1 0 01.504-.868l6-3zM10 4.618L4.802 7.5 10 10.382 15.198 7.5 10 4.618zM15 9.035l-4.223 2.815a1.002 1.002 0 01-1.554 0L5 9.035V14.5l5 3.333 5-3.333V9.035z" clip-rule="evenodd"></path>
                         </svg>
                    </a>
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                        Buat Akun Baru
                    </h2>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                        Isi detail di bawah untuk mendaftar.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                    @csrf

                    <div class="relative group">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none z-20">
                            <i class="fas fa-user text-slate-400 group-focus-within:text-red-600 dark:text-slate-500 dark:group-focus-within:text-red-500 transition-colors duration-300"></i>
                        </div>
                        <input
                            id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder=" "
                            class="block ps-10 pe-3.5 py-3.5 w-full text-sm text-slate-900 dark:text-white bg-transparent rounded-lg border-2 border-slate-300 dark:border-slate-600 appearance-none focus:outline-none focus:ring-0 focus:border-red-600 dark:focus:border-red-500 peer"
                        />
                        <label
                            for="name"
                            class="absolute text-sm text-slate-500 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-slate-50 dark:bg-slate-900 px-2 peer-focus:px-2 peer-focus:text-red-600 dark:peer-focus:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[38px] peer-placeholder-shown:start-[38px] peer-focus:start-3"
                        >
                            {{ __('Nama Lengkap') }}
                        </label>
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs" />
                    </div>

                    <div class="relative group">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none z-20">
                            <i class="fas fa-envelope text-slate-400 group-focus-within:text-red-600 dark:text-slate-500 dark:group-focus-within:text-red-500 transition-colors duration-300"></i>
                        </div>
                        <input
                            id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder=" "
                            class="block ps-10 pe-3.5 py-3.5 w-full text-sm text-slate-900 dark:text-white bg-transparent rounded-lg border-2 border-slate-300 dark:border-slate-600 appearance-none focus:outline-none focus:ring-0 focus:border-red-600 dark:focus:border-red-500 peer"
                        />
                        <label
                            for="email"
                            class="absolute text-sm text-slate-500 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-slate-50 dark:bg-slate-900 px-2 peer-focus:px-2 peer-focus:text-red-600 dark:peer-focus:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[38px] peer-placeholder-shown:start-[38px] peer-focus:start-3"
                        >
                            {{ __('Alamat Email') }}
                        </label>
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs" />
                    </div>

                    <div class="relative group">
                         <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none z-20">
                            <i class="fas fa-lock text-slate-400 group-focus-within:text-red-600 dark:text-slate-500 dark:group-focus-within:text-red-500 transition-colors duration-300"></i>
                        </div>
                        <input
                            id="password" type="password" name="password" required autocomplete="new-password" placeholder=" "
                            class="block ps-10 pe-3.5 py-3.5 w-full text-sm text-slate-900 dark:text-white bg-transparent rounded-lg border-2 border-slate-300 dark:border-slate-600 appearance-none focus:outline-none focus:ring-0 focus:border-red-600 dark:focus:border-red-500 peer"
                        />
                        <label
                            for="password"
                            class="absolute text-sm text-slate-500 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-slate-50 dark:bg-slate-900 px-2 peer-focus:px-2 peer-focus:text-red-600 dark:peer-focus:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[38px] peer-placeholder-shown:start-[38px] peer-focus:start-3"
                        >
                            {{ __('Kata Sandi') }}
                        </label>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs" />
                    </div>

                    <div class="relative group">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none z-20">
                            <i class="fas fa-shield-alt text-slate-400 group-focus-within:text-red-600 dark:text-slate-500 dark:group-focus-within:text-red-500 transition-colors duration-300"></i> {{-- Ikon sedikit beda untuk konfirmasi --}}
                        </div>
                        <input
                            id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder=" "
                            class="block ps-10 pe-3.5 py-3.5 w-full text-sm text-slate-900 dark:text-white bg-transparent rounded-lg border-2 border-slate-300 dark:border-slate-600 appearance-none focus:outline-none focus:ring-0 focus:border-red-600 dark:focus:border-red-500 peer"
                        />
                        <label
                            for="password_confirmation"
                            class="absolute text-sm text-slate-500 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-slate-50 dark:bg-slate-900 px-2 peer-focus:px-2 peer-focus:text-red-600 dark:peer-focus:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[38px] peer-placeholder-shown:start-[38px] peer-focus:start-3"
                        >
                            {{ __('Konfirmasi Kata Sandi') }}
                        </label>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-700 hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-slate-900 transition-colors duration-150">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm text-slate-600 dark:text-slate-400">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold leading-6 text-red-600 hover:text-red-500 dark:text-red-500 dark:hover:text-red-400">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>