<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIEKSA') }} - Musahil</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
        
        {{-- Vite akan meng-handle CSS dan JS utama Anda, termasuk Alpine.js --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Font Awesome (jika via CDN) --}}
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" /> --}}
        
        {{-- Style untuk AlpineJS x-cloak --}}
        <style>[x-cloak] { display: none !important; }</style>
        
        {{-- Slot untuk script spesifik per halaman --}}
        @stack('scripts')
    </head>
    <body class="font-['Instrument_Sans'] antialiased" x-data="{ sidebarOpen: false, showModal: false, daftarUrl: '', detailModal : false, detailData : {} }" @keydown.escape.window="sidebarOpen = false""
          {{-- State Alpine.js untuk kontrol UI global --}}
          x-data="{ sidebarOpen: false }"
          @keydown.escape.window="sidebarOpen = false">
        
        <div class="min-h-screen bg-slate-100 dark:bg-slate-900 md:flex">

            {{-- Sidebar Backdrop untuk Mobile (Overlay Gelap) --}}
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

            {{-- 1. Sidebar Khusus Musahil --}}
            {{-- Pastikan Anda memiliki file sidebar khusus ini --}}
            @include('layouts.sidebar-musahil')

            {{-- 2. Area Konten Utama (Kanan Sidebar) --}}
            <div class="flex-1 flex flex-col md:h-screen md:overflow-y-auto">
                
                {{-- Navigasi Atas (yang berisi tombol hamburger) --}}
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

                

                <main class="flex-grow p-4 sm:p-6 lg:px-8">
                    {{ $slot }}
                </main>

                {{-- Footer jika ingin ada di setiap halaman dashboard --}}
                @include('layouts.footer')
            </div>
        </div>
    </body>
</html>