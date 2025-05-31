<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIEKSA - Sistem Ekstrakurikuler Asrama</title> {{-- Judul diubah --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" /> {{-- Ditambahkan font-weight 700 --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Pastikan CSS Fallback ini LENGKAP jika Vite tidak aktif --}}
        <style>
            /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */@layer theme{/*! ... (CSS Tailwind bawaan Anda yang sangat panjang ada di sini, pastikan ini lengkap jika Anda mengandalkan fallback ini) ... */}@layer base{*,:after,:before,::backdrop{box-sizing:border-box;border:0 solid;margin:0;padding:0}::file-selector-button{box-sizing:border-box;border:0 solid;margin:0;padding:0}html,:host{-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;line-height:1.5;font-family:var(--default-font-family,ui-sans-serif,system-ui,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji");font-feature-settings:var(--default-font-feature-settings,normal);font-variation-settings:var(--default-font-variation-settings,normal);-webkit-tap-highlight-color:transparent}body{line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;-webkit-text-decoration:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,samp,pre{font-family:var(--default-mono-font-family,ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace);font-feature-settings:var(--default-mono-font-feature-settings,normal);font-variation-settings:var(--default-mono-font-variation-settings,normal);font-size:1em}small{font-size:80%}sub,sup{vertical-align:baseline;font-size:75%;line-height:0;position:relative}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}:-moz-focusring{outline:auto}progress{vertical-align:baseline}summary{display:list-item}ol,ul,menu{list-style:none}img,svg,video,canvas,audio,iframe,embed,object{vertical-align:middle;display:block}img,video{max-width:100%;height:auto}button,input,select,optgroup,textarea{font:inherit;font-feature-settings:inherit;font-variation-settings:inherit;letter-spacing:inherit;color:inherit;opacity:1;background-color:#0000;border-radius:0}::file-selector-button{font:inherit;font-feature-settings:inherit;font-variation-settings:inherit;letter-spacing:inherit;color:inherit;opacity:1;background-color:#0000;border-radius:0}:where(select:is([multiple],[size])) optgroup{font-weight:bolder}:where(select:is([multiple],[size])) optgroup option{padding-inline-start:20px}::file-selector-button{margin-inline-end:4px}::placeholder{opacity:1;color:color-mix(in oklab,currentColor 50%,transparent)}textarea{resize:vertical}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-date-and-time-value{min-height:1lh;text-align:inherit}::-webkit-datetime-edit{display:inline-flex}::-webkit-datetime-edit-fields-wrapper{padding:0}::-webkit-datetime-edit{padding-block:0}::-webkit-datetime-edit-year-field{padding-block:0}::-webkit-datetime-edit-month-field{padding-block:0}::-webkit-datetime-edit-day-field{padding-block:0}::-webkit-datetime-edit-hour-field{padding-block:0}::-webkit-datetime-edit-minute-field{padding-block:0}::-webkit-datetime-edit-second-field{padding-block:0}::-webkit-datetime-edit-millisecond-field{padding-block:0}::-webkit-datetime-edit-meridiem-field{padding-block:0}:-moz-ui-invalid{box-shadow:none}button,input:where([type=button],[type=reset],[type=submit]){-webkit-appearance:button;-moz-appearance:button;appearance:button}::file-selector-button{-webkit-appearance:button;-moz-appearance:button;appearance:button}::-webkit-inner-spin-button{height:auto}::-webkit-outer-spin-button{height:auto}[hidden]:where(:not([hidden=until-found])){display:none!important}}@layer components;@layer utilities{/*! ... (CSS Tailwind bawaan Anda yang sangat panjang ada di sini, pastikan ini lengkap jika Anda mengandalkan fallback ini) ... */}@keyframes spin{to{transform:rotate(360deg)}}@keyframes ping{75%,to{opacity:0;transform:scale(2)}}@keyframes pulse{50%{opacity:.5}}@keyframes bounce{0%,to{animation-timing-function:cubic-bezier(.8,0,1,1);transform:translateY(-25%)}50%{animation-timing-function:cubic-bezier(0,0,.2,1);transform:none}}@property --tw-translate-x{syntax:"*";inherits:false;initial-value:0}@property --tw-translate-y{syntax:"*";inherits:false;initial-value:0}@property --tw-translate-z{syntax:"*";inherits:false;initial-value:0}@property --tw-rotate-x{syntax:"*";inherits:false;initial-value:rotateX(0)}@property --tw-rotate-y{syntax:"*";inherits:false;initial-value:rotateY(0)}@property --tw-rotate-z{syntax:"*";inherits:false;initial-value:rotateZ(0)}@property --tw-skew-x{syntax:"*";inherits:false;initial-value:skewX(0)}@property --tw-skew-y{syntax:"*";inherits:false;initial-value:skewY(0)}@property --tw-space-x-reverse{syntax:"*";inherits:false;initial-value:0}@property --tw-border-style{syntax:"*";inherits:false;initial-value:solid}@property --tw-leading{syntax:"*";inherits:false}@property --tw-font-weight{syntax:"*";inherits:false}@property --tw-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-shadow-color{syntax:"*";inherits:false}@property --tw-inset-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-inset-shadow-color{syntax:"*";inherits:false}@property --tw-ring-color{syntax:"*";inherits:false}@property --tw-ring-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-inset-ring-color{syntax:"*";inherits:false}@property --tw-inset-ring-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-ring-inset{syntax:"*";inherits:false}@property --tw-ring-offset-width{syntax:"<length>";inherits:false;initial-value:0}@property --tw-ring-offset-color{syntax:"*";inherits:false;initial-value:#fff}@property --tw-ring-offset-shadow{syntax:"*";inherits:false;initial-value:0 0 #0000}@property --tw-blur{syntax:"*";inherits:false}@property --tw-brightness{syntax:"*";inherits:false}@property --tw-contrast{syntax:"*";inherits:false}@property --tw-grayscale{syntax:"*";inherits:false}@property --tw-hue-rotate{syntax:"*";inherits:false}@property --tw-invert{syntax:"*";inherits:false}@property --tw-opacity{syntax:"*";inherits:false}@property --tw-saturate{syntax:"*";inherits:false}@property --tw-sepia{syntax:"*";inherits:false}@property --tw-drop-shadow{syntax:"*";inherits:false}@property --tw-duration{syntax:"*";inherits:false}@property --tw-content{syntax:"*";inherits:false;initial-value:""}</style>
    @endif
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 min-h-screen flex flex-col font-['Instrument_Sans']">

    {{-- Header yang sudah ada --}}
    <header x-data="{ mobileMenuOpen: false }" @keydown.escape.window="mobileMenuOpen = false" class="bg-white dark:bg-slate-900/95 backdrop-blur-sm shadow-md w-full sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-red-700 dark:text-red-500">
                    SIEKSA
                </a>
            </div>

            <nav class="hidden md:flex items-center space-x-3 lg:space-x-5">
                {{-- Navigasi utama desktop kosong --}}
            </nav>

            <div class="flex items-center space-x-2 md:space-x-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="hidden sm:inline-block px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-md">
                            Dashboard
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hidden lg:inline-block px-3 py-2 text-sm font-medium text-red-700 dark:text-red-500 border border-red-700 dark:border-red-500 hover:bg-red-50 dark:hover:bg-red-700/10 rounded-md">
                                Register
                            </a>
                        @endif
                        <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium text-white bg-red-700 hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700 rounded-md">
                            Log in
                        </a>
                    @endauth
                @endif

                <button class="p-1 text-gray-500 dark:text-gray-400 hover:text-red-700 dark:hover:text-red-500" aria-label="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
                <button class="p-1 text-gray-500 dark:text-gray-400 hover:text-red-700 dark:hover:text-red-500" aria-label="Select language">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                </button>

                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" :aria-expanded="mobileMenuOpen.toString()" aria-controls="mobile-menu-alpine" aria-label="Open mobile menu" class="p-1 text-gray-500 dark:text-gray-400 hover:text-red-700 dark:hover:text-red-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-cloak @click.away="mobileMenuOpen = false"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             id="mobile-menu-alpine" class="md:hidden absolute top-full inset-x-0 bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-700 shadow-lg ring-1 ring-black ring-opacity-5"
             :aria-hidden="(!mobileMenuOpen).toString()">
            <nav class="px-2 pt-2 pb-4 space-y-1">
                {{-- Navigasi mobile kosong --}}
            </nav>
            @if (Route::has('login'))
                <div class="pt-4 pb-3 border-t border-gray-200 dark:border-slate-700">
                    <div class="px-5 space-y-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 hover:text-red-700 dark:hover:text-red-500">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" @click="mobileMenuOpen = false" class="block w-full px-3 py-2 text-center rounded-md text-base font-medium text-white bg-red-700 hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700">Log in</a>
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" @click="mobileMenuOpen = false" class="block w-full mt-1 px-3 py-2 text-center rounded-md text-base font-medium text-red-700 dark:text-red-500 hover:bg-red-50 dark:hover:bg-red-700/10 border border-red-700 dark:border-red-500">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </header>
    {{-- Akhir Header --}}

    <main class="flex-grow">
        {{-- Hero Section --}}
        <section
            x-data="{
                textToType: 'SIEKSA',
                typedText: '',
                taglineToType: 'Sistem Ekstrakurikuler Asrama',
                typedTagline: '',
                typingSpeed: 120,
                taglineDelay: 500,
                cursorVisible: true,
                startTyping() {
                    let i = 0;
                    const typeChar = () => {
                        if (i < this.textToType.length) {
                            this.typedText += this.textToType.charAt(i);
                            i++;
                            setTimeout(typeChar, this.typingSpeed);
                        } else {
                            setTimeout(() => this.startTypingTagline(), this.taglineDelay);
                        }
                    };
                    typeChar();
                    setInterval(() => { this.cursorVisible = !this.cursorVisible; }, 500);
                },
                startTypingTagline() {
                    let j = 0;
                    const typeTaglineChar = () => {
                        if (j < this.taglineToType.length) {
                            this.typedTagline += this.taglineToType.charAt(j);
                            j++;
                            setTimeout(typeTaglineChar, this.typingSpeed / 2);
                        }
                    };
                    typeTaglineChar();
                }
            }"
            x-init="startTyping()"
            class="bg-red-800 dark:bg-red-900 min-h-[calc(100vh-4rem)] flex flex-col items-center justify-center text-center text-white p-8 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/20 dark:bg-black/30"></div> {{-- Overlay tipis --}}
            <div class="relative z-10">
                <h1 class="text-5xl sm:text-6xl md:text-7xl lg:text-8xl font-bold mb-4 tracking-tight">
                    <span x-text="typedText"></span><span x-show="cursorVisible && typedText.length < textToType.length" class="animate-pulse">_</span>
                </h1>
                <p class="text-xl sm:text-2xl md:text-3xl font-light text-red-100 dark:text-red-200 min-h-[2em]">
                    <span x-text="typedTagline"></span><span x-show="cursorVisible && typedText.length === textToType.length && typedTagline.length < taglineToType.length" class="animate-pulse">_</span>
                </p>
            </div>
             {{-- Icon panah scroll down --}}
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 animate-bounce">
                <svg class="w-8 h-8 text-white/70" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </section>

        {{-- Description Section --}}
        <section class="py-16 lg:py-24 bg-gray-50 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="max-w-3xl mx-auto text-center mb-12 lg:mb-16"
                     x-data="{ shown: false }" x-intersect:enter.once="shown = true"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                     class="transition-all duration-700 ease-out">
                    <h2 class="text-3xl lg:text-4xl font-bold text-red-700 dark:text-red-500 mb-4">Apa itu SIEKSA?</h2>
                </div>
                <div class="max-w-3xl mx-auto space-y-4 text-lg leading-relaxed">
                    @php
                        $descriptionLines = [
                            "SIEKSA adalah singkatan dari Sistem Informasi Ekstrakurikuler Asrama.",
                            "Dirancang khusus untuk merevolusi cara pengelolaan kegiatan non-akademik di lingkungan asrama Anda.",
                            "Platform ini bertujuan untuk menjadi jembatan digital yang menghubungkan siswa, pembina, dan manajemen asrama.",
                            "Dengan fitur yang intuitif, SIEKSA memudahkan pendaftaran, penjadwalan, pemantauan kehadiran, hingga dokumentasi setiap ekstrakurikuler.",
                            "Temukan bakat terpendam, kembangkan potensi diri, dan raih prestasi melalui beragam pilihan kegiatan yang kami tawarkan!"
                        ];
                    @endphp
                    @foreach($descriptionLines as $index => $line)
                    <div x-data="{ shown: false }" x-intersect:enter.once="shown = true">
                        <p :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                           class="transition-all duration-500 ease-out"
                           style="transition-delay: {{ $index * 150 }}ms;">
                           {{ $line }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Visi Misi / Keunggulan Section --}}
        <section class="py-16 lg:py-24 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="text-center mb-12 lg:mb-16"
                     x-data="{ shown: false }" x-intersect:enter.once="shown = true"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                     class="transition-all duration-700 ease-out">
                    <h2 class="text-3xl lg:text-4xl font-bold text-red-700 dark:text-red-500 mb-4">Mengapa Memilih SIEKSA?</h2>
                    <p class="text-lg max-w-2xl mx-auto">Kami hadir untuk memberikan solusi terbaik dalam mengelola dan memaksimalkan potensi ekstrakurikuler di asrama.</p>
                </div>
                <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                    {{-- Card Kiri: Visi --}}
                    <div x-data="{ shown: false }" x-intersect:enter.once="shown = true"
                         :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-10'"
                         class="transition-all duration-700 ease-out delay-100 bg-gray-50 dark:bg-slate-800 p-8 rounded-xl shadow-lg">
                        <div class="flex items-center mb-4">
                            <svg class="w-10 h-10 text-red-600 dark:text-red-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <h3 class="text-2xl font-semibold text-slate-800 dark:text-white">Visi Kami</h3>
                        </div>
                        <p class="text-md leading-relaxed">Menjadi platform digital terdepan dalam mendukung pengembangan minat, bakat, dan karakter siswa asrama melalui kegiatan ekstrakurikuler yang terintegrasi, inovatif, dan berkualitas.</p>
                    </div>
                    {{-- Card Kanan: Misi --}}
                    <div x-data="{ shown: false }" x-intersect:enter.once="shown = true"
                         :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-10'"
                         class="transition-all duration-700 ease-out delay-200 bg-gray-50 dark:bg-slate-800 p-8 rounded-xl shadow-lg">
                         <div class="flex items-center mb-4">
                            <svg class="w-10 h-10 text-red-600 dark:text-red-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <h3 class="text-2xl font-semibold text-slate-800 dark:text-white">Misi Utama</h3>
                        </div>
                        <ul class="list-disc list-inside space-y-2 text-md leading-relaxed">
                            <li>Menyediakan sistem pendaftaran yang mudah dan transparan.</li>
                            <li>Memfasilitasi pengelolaan jadwal dan kehadiran secara efisien.</li>
                            <li>Mendorong partisipasi aktif siswa dalam beragam kegiatan.</li>
                            <li>Menyajikan informasi dan dokumentasi kegiatan yang menarik.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- Extracurricular Section --}}
        <section class="py-16 lg:py-24 bg-gray-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="text-center mb-12 lg:mb-16"
                     x-data="{ shown: false }" x-intersect:enter.once="shown = true"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                     class="transition-all duration-700 ease-out">
                    <h2 class="text-3xl lg:text-4xl font-bold text-red-700 dark:text-red-500 mb-4">Jelajahi Ekstrakurikuler Unggulan</h2>
                    <p class="text-lg max-w-2xl mx-auto">Temukan beragam kegiatan yang sesuai dengan minat dan bakatmu. Kembangkan diri dan raih prestasi bersama SIEKSA!</p>
                </div>
                @php
                    $extracurriculars = [
                        ['title' => 'Klub Robotik', 'icon' => '<svg class="w-12 h-12 text-red-600 dark:text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'description' => 'Asah logika dan kreativitasmu dalam merancang dan membangun robot. Belajar pemrograman, mekanika, dan elektronika dasar.' ],
                        ['title' => 'Debat Bahasa Inggris', 'icon' => '<svg class="w-12 h-12 text-red-600 dark:text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>', 'description' => 'Tingkatkan kemampuan berpikir kritis dan berbicara di depan umum. Persiapkan diri untuk kompetisi dan diskusi global.' ],
                        ['title' => 'Seni Musik (Band/Vokal)', 'icon' => '<svg class="w-12 h-12 text-red-600 dark:text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>', 'description' => 'Salurkan bakat musikmu! Belajar instrumen, olah vokal, dan berkolaborasi dalam grup musik.' ],
                        ['title' => 'Fotografi & Videografi', 'icon' => '<svg class="w-12 h-12 text-red-600 dark:text-red-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>', 'description' => 'Abadikan momen dan ceritakan kisah melalui lensa kamera. Pelajari teknik pengambilan gambar, editing, dan sinematografi.' ],
                    ];
                @endphp
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($extracurriculars as $index => $item)
                    <div x-data="{ shown: false }" x-intersect:enter.once="shown = true"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                         class="transition-all duration-500 ease-out bg-white dark:bg-slate-900 p-6 rounded-xl shadow-lg text-center"
                         style="transition-delay: {{ ($index % 2) * 100 + floor($index / 2) * 50 }}ms;"> {{-- Staggered delay --}}
                        <div class="flex justify-center">
                            {!! $item['icon'] !!}
                        </div>
                        <h3 class="text-xl font-semibold text-slate-800 dark:text-white mb-2">{{ $item['title'] }}</h3>
                        <p class="text-sm leading-relaxed">{{ $item['description'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

    </main>

    {{-- Footer Sederhana --}}
    <footer class="bg-slate-800 dark:bg-slate-950 text-slate-300 dark:text-slate-400 py-8 text-center">
        <div class="container mx-auto px-6">
            <p>&copy; {{ date('Y') }} SIEKSA - Sistem Ekstrakurikuler Asrama. All rights reserved.</p>
            <p class="text-sm mt-1">Dikembangkan dengan ❤️ untuk kemajuan asrama.</p>
        </div>
    </footer>

</body>
</html>