<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIEKSAd') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
        
        {{-- Vite akan meng-handle CSS dan JS utama Anda, termasuk Alpine.js --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Font Awesome via CDN (jika Anda memilih cara ini) --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- Style untuk AlpineJS x-cloak --}}
        <style>[x-cloak] { display: none !important; }</style>

        {{-- HAPUS SEMUA PEMANGGILAN SCRIPT DARI CDN DI SINI --}}
        {{-- <script defer src=".../alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <script src=".../sweetalert2@11"></script>
{{--  
        <script src=".../qrcode-generator/qrcode.js"></script> --}}
    </head>
    <body class="font-['Instrument_Sans'] antialiased" x-data="{ sidebarOpen: false }">
        
        <div class="min-h-screen bg-slate-100 dark:bg-slate-900 md:flex">

            {{-- ... (kode untuk Backdrop, Sidebar, dan Area Konten Utama Anda) ... --}}
            @include('layouts.sidebar')

            <div class="flex-1 flex flex-col md:h-screen md:overflow-y-auto">
                @include('layouts.navigation')

                @isset($header)
                    <header class="bg-white dark:bg-slate-800 shadow shrink-0">
                        
                        {{-- ... (kode header dan navbar_ekstra Anda) ... --}}
                    </header>
                @endisset

                <main class="flex-grow p-4 sm:p-6 lg:px-8">
                    {{ $slot }}
                </main>

                @include('layouts.footer')
            </div>

        </div>

        {{-- KUNCI PERBAIKAN: Tempat untuk script spesifik per halaman --}}
        {{-- Pastikan ini ada TEPAT SEBELUM tag </body> penutup --}}
        @stack('scripts')
    </body>
</html>