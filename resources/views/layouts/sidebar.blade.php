{{-- resources/views/layouts/sidebar.blade.php --}}
<aside
    class="w-64 bg-slate-100 dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 flex flex-col
           fixed inset-y-0 left-0 z-40
           transform transition-transform duration-300 ease-in-out
           md:sticky md:top-0 md:h-screen md:overflow-y-auto md:shrink-0 md:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    x-cloak>

    {{-- Header Sidebar --}}
    <div class="h-16 flex items-center justify-between px-4 border-b border-slate-200 dark:border-slate-700 shrink-0">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-red-700 dark:text-red-500">
            SIEKSAd Panel
        </a>
        <button @click="sidebarOpen = false" class="md:hidden text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 p-1 -mr-1">
            <i class="fas fa-times text-xl"></i>
            <span class="sr-only">Tutup menu</span>
        </button>
    </div>

    <nav class="flex-grow p-4 space-y-2 overflow-y-auto">
        @php
            $currentRoute = request()->route() ? request()->route()->getName() : '';
            $baseLinkClass = 'flex items-center px-3 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 group';
            $activeLinkClass = 'bg-red-100 dark:bg-red-800/60 text-red-700 dark:text-red-400 font-semibold';
            $inactiveLinkClass = 'text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700';
            $activeIconClass = 'text-red-600 dark:text-red-400';
            $inactiveIconClass = 'text-slate-500 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200';
        @endphp

        {{-- 1. Link Dashboard (Tidak Diubah) --}}
        @php
            $isDashboardActive = Str::contains($currentRoute, 'dashboard');
            $dashboardClasses = $baseLinkClass . ' ' . ($isDashboardActive ? $activeLinkClass : $inactiveLinkClass);
            $dashboardIconClasses = $isDashboardActive ? $activeIconClass : $inactiveIconClass;
        @endphp
        <a href="{{ route('dashboard') }}"
           class="{{ $dashboardClasses }}"
           @click="if(window.innerWidth < 768) sidebarOpen = false">
            <i class="fas fa-tachometer-alt w-5 h-5 me-3 {{ $dashboardIconClasses }} transition-colors duration-150"></i>
            Dashboard
        </a>

        @php
            $isEkstrakurikulerActive = Str::contains($currentRoute, 'ekstra');
            $ekstrakurikulerLinkClasses = 'w-full flex items-center justify-between px-3 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 group ';
            $ekstrakurikulerLinkClasses .= $isEkstrakurikulerActive
                ? 'bg-red-100 dark:bg-red-700/20 text-red-700 dark:text-red-400 font-semibold'
                : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-slate-100';

            $ekstrakurikulerIconClasses = $isEkstrakurikulerActive
                ? 'text-red-600 dark:text-red-400'
                : 'text-slate-500 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200';
        @endphp

        <div x-data="{ 
                open: {{ $isEkstrakurikulerActive ? 'true' : 'false' }},
                // Jika aktif, lock supaya dropdown tidak bisa ditutup
                toggle() {
                    if (!{{ $isEkstrakurikulerActive ? 'true' : 'false' }}) {
                        this.open = !this.open;
                    }
                }
            }"
        >
            <button @click="toggle()" class="{{ $ekstrakurikulerLinkClasses }} text-left">
                <span class="flex items-center">
                    <i class="fas fa-puzzle-piece w-5 h-5 me-3 {{ $ekstrakurikulerIconClasses }} transition-colors duration-150"></i>
                    Ekstrakurikuler
                </span>
                <i class="fas w-4 h-4 transform transition-transform duration-200 text-slate-500 group-hover:text-slate-700"
                :class="{'fa-chevron-down': !open, 'fa-chevron-up': open}"></i>
            </button>

        @php
            $user = Auth::user();
        @endphp
        @if($user->hasRole('pj') || $user->hasRole('warga') || $user->hasRole('musahil'))
            <div x-show="open" x-transition ... class="mt-1 ms-4 ps-3 border-l-2 ..." x-cloak>
                @php
                    $user = Auth::user();
                    $ekstra = $user->ekstrakurikuler;
                @endphp

                @if ($ekstra && $ekstra->id_ekstrakurikuler != '' && $user->id_ekstrakurikuler != '')
                    @if ($ekstra)
                        @php
                            $data_ekstra = [[
                                'nama' => $ekstra->nama_ekstra,
                                'icon' => 'fa-cogs',
                                'route_name' => 'detail_ekstra', 
                                'param' => $ekstra->id_ekstrakurikuler
                            ]];
                        @endphp

                        @foreach($data_ekstra as $kelas)
                            @php
                                $isKelasActive = Str::contains($currentRoute, 'ekstra');
                                $kelasLinkClasses = 'flex items-center w-full ps-3 pe-2 py-2 rounded-md text-sm transition-colors duration-150 group ';
                                $kelasLinkClasses .= $isKelasActive
                                    ? 'bg-red-100 dark:bg-red-700/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 -ml-[14px] pl-[10px] font-semibold'
                                    : 'text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-slate-100';
                                $kelasIconClasses = $isKelasActive
                                    ? 'text-red-600 dark:text-red-400'
                                    : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300';
                            @endphp
                            <a href="{{ route($user->role.'.'.$kelas['route_name'], $kelas['param']) }}"
                            class="{{ $kelasLinkClasses }}"
                            @click="if(window.innerWidth < 768) sidebarOpen = false">
                                <i class="fas {{ $kelas['icon'] }} w-4 h-4 me-2.5 {{ $kelasIconClasses }} transition-colors duration-150 opacity-80"></i>
                                {{ ucwords($kelas['nama']) }}
                            </a>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
        @endif

        
        {{-- 3. Link untuk Fitur Absensi (Dinamis berdasarkan Role) --}}
        @if(Auth::user()->hasRole('warga') || Auth::user()->hasRole('musahil'))
            {{-- Link untuk Warga & Musahil membuka halaman scanner --}}
            @php $isAbsensiActive = request()->routeIs('warga.absensi_ekstra'); @endphp
            <a href="{{ route('warga.absensi_ekstra') }}"
               class="{{ $baseLinkClass }} {{ $isAbsensiActive ? $activeLinkClass : $inactiveLinkClass }}"
               @click="if(window.innerWidth < 768) sidebarOpen = false">
                <i class="fas fa-camera w-5 h-5 me-3 {{ $isAbsensiActive ? $activeIconClass : $inactiveIconClass }} transition-colors duration-150"></i>
                Lakukan Absensi
            </a>
        @endif

        @if(Auth::user()->hasRole('pj'))
            @php $isListWargaActive = request()->routeIs('pj.list-warga'); @endphp
            <a href="{{ route('pj.list-warga') }}"
            class="{{ $baseLinkClass }} {{ $isListWargaActive ? $activeLinkClass : $inactiveLinkClass }}"
            @click="if(window.innerWidth < 768) sidebarOpen = false">
                <i class="fas fa-users me-3 w-5 text-center {{ $isListWargaActive ? $activeIconClass : $inactiveIconClass }}"></i>
                Warga Didampingi
            </a>

            {{-- Untuk PJ, link ini bisa mengarah ke halaman index untuk memilih ekskul mana yang akan dikelola absensinya --}}
            {{-- Atau Anda bisa membuat dropdown baru seperti menu 'Manajemen PJ' di respons saya sebelumnya --}}
            @php $isKelolaAbsensiActive = request()->routeIs('pj.absensi.index'); @endphp
            <a href="{{route('pj.absensi.index')}}" {{-- Ganti dengan route index manajemen absensi oleh PJ --}}
               class="{{ $baseLinkClass }} {{ $isKelolaAbsensiActive ? $activeLinkClass : $inactiveLinkClass }}"
               @click="if(window.innerWidth < 768) sidebarOpen = false">
                <i class="fas fa-qrcode w-5 h-5 me-3 {{ $isKelolaAbsensiActive ? $activeIconClass : $inactiveIconClass }} transition-colors duration-150"></i>
                Kelola Absensi
            </a>
        @endif
        @if($user->hasRole('admin'))
            @php $isManajemenActive = Str::startsWith($currentRoute, 'admin.'); @endphp
            <div class="pt-2">
                <h3 class="px-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Manajemen Sistem</h3>
                <div class="mt-2 space-y-1">
                    {{-- Ganti href dengan route manajemen yang sesuai nanti --}}
                    <a href="{{route('admin.pengguna.index')}}" class="{{ $baseLinkClass }} {{ $inactiveLinkClass }}">
                        <i class="fas fa-users-cog me-3 w-5 text-center {{ $inactiveIconClass }}"></i>
                        Kelola Pengguna
                    </a>
                    <a href="{{route('admin.users.index')}}" class="{{ $baseLinkClass }} {{ $inactiveLinkClass }}">
                        <i class="fas fa-users-cog me-3 w-5 text-center {{ $inactiveIconClass }}"></i>
                        Kelola Akun
                    </a>
                    <a href="{{route('admin.ekstrakurikuler.index')}}" class="{{ $baseLinkClass }} {{ $inactiveLinkClass }}">
                        <i class="fas fa-puzzle-piece me-3 w-5 text-center {{ $inactiveIconClass }}"></i>
                        Kelola Ekstrakurikuler
                    </a>
                    <a href="#" class="{{ $baseLinkClass }} {{ $inactiveLinkClass }}">
                        <i class="fas fa-calendar-alt me-3 w-5 text-center {{ $inactiveIconClass }}"></i>
                        Kelola Jadwal
                    </a>
                    <a href="{{route('admin.daftar_materi_ekstra')}}" class="{{ $baseLinkClass }} {{ $inactiveLinkClass }}">
                        <i class="fas fa-book-open me-3 w-5 text-center {{ $inactiveIconClass }}"></i>
                        Kelola Materi
                    </a>
                     <a href="{{route('admin.daftar_absensi_ekstra')}}" class="{{ $baseLinkClass }} {{ $inactiveLinkClass }}">
                        <i class="fas fa-clipboard-list me-3 w-5 text-center {{ $inactiveIconClass }}"></i>
                        Kelola Absensi
                    </a>
                </div>
            </div>
        @endif
        
        {{-- ... Sisa menu sidebar Anda seperti Pengaturan ... --}}
    </nav>

    {{-- Bagian Pengaturan di Bawah --}}
    <div class="p-4 border-t border-slate-200 dark:border-slate-700 mt-auto shrink-0">
         @php $isPengaturanActive = request()->routeIs('profile.edit'); @endphp
         <a href="{{ route('profile.edit') }}"
           class="{{ $baseLinkClass }} {{ $isPengaturanActive ? $activeLinkClass : $inactiveLinkClass }}"
           @click="if(window.innerWidth < 768) sidebarOpen = false">
            <i class="fas fa-cog w-5 h-5 me-3 {{ $isPengaturanActive ? $activeIconClass : $inactiveIconClass }} transition-colors duration-150"></i>
            Profil & Pengaturan
        </a>
    </div>
</aside>