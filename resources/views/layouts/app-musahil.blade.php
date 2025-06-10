<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- Font Awesome CDN (jika tidak via NPM) --}}
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" /> --}}
        <style>[x-cloak] { display: none !important; }</style>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-['Instrument_Sans'] antialiased" x-data="{ sidebarOpen: false, showModal: false, daftarUrl: '', detailModal : false, detailData : {} }" @keydown.escape.window="sidebarOpen = false">
        <div class="min-h-screen bg-slate-100 dark:bg-slate-900 md:flex">

            {{-- Sidebar Backdrop untuk Mobile --}}
            <div x-show="sidebarOpen"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-slate-900/50 z-30 md:hidden"
                 x-cloak
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
            </div>

            {{-- 1. Sidebar --}}
            @include('layouts.sidebar-musahil') {{-- sidebar.blade.php akan menggunakan sidebarOpen --}}

            {{-- 2. Area Konten Utama (Kanan Sidebar) --}}
            <div class="flex-1 flex flex-col h-screen md:overflow-y-auto">
                
                {{-- Navigasi Atas (akan memiliki tombol hamburger untuk sidebarOpen) --}}
                @include('layouts.navigation')

                @isset($header)
                    <header class="bg-white dark:bg-slate-800 shadow">
                        <div class="max-w-full mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
                
                @isset($navbar_ekstra)
                    <nav class="bg-slate-100 dark:bg-slate-800 shadow">
                        <div class="max-w-full mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{$navbar_ekstra}}
                        </div>
                    </nav>                
                @endisset
                <main class="flex-grow p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>