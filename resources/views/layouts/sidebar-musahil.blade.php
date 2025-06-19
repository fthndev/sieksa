{{-- resources/views/layouts/sidebar-musahil.blade.php --}}
<aside
    x-cloak
    class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 flex-col border-r border-slate-200 bg-slate-100 transition-transform duration-300 ease-in-out dark:border-slate-700 dark:bg-slate-800
           md:relative md:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    {{-- Header Sidebar --}}
    <div class="flex h-16 shrink-0 items-center justify-between border-b border-slate-200 px-4 dark:border-slate-700">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-red-700 dark:text-red-500">
            SIEKSA Panel
        </a>
        <button @click="sidebarOpen = false" class="-mr-1 p-1 text-slate-500 hover:text-red-600 dark:text-slate-400 dark:hover:text-red-400 md:hidden">
            <i class="fas fa-times text-xl"></i>
            <span class="sr-only">Tutup menu</span>
        </button>
    </div>

    {{-- Navigasi Utama --}}
    <nav class="flex-grow space-y-1 overflow-y-auto p-4">
        @php
            // Variabel untuk styling agar lebih rapi
            $currentRoute = request()->route() ? request()->route()->getName() : '';
            $baseLinkClass = 'flex items-center px-3 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 group';
            $activeLinkClass = 'bg-red-100 dark:bg-red-800/60 text-red-700 dark:text-red-400 font-semibold';
            $inactiveLinkClass = 'text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700';
            $activeIconClass = 'text-red-600 dark:text-red-400';
            $inactiveIconClass = 'text-slate-500 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200';
        @endphp

        {{-- 1. Link Dashboard Musahil --}}
        @php $isDashboardActive = request()->routeIs('musahil.dashboard'); @endphp
        <a href="{{ route('musahil.dashboard') }}"
           class="{{ $baseLinkClass }} {{ $isDashboardActive ? $activeLinkClass : $inactiveLinkClass }}"
           @click="if(window.innerWidth < 768) sidebarOpen = false">
            <i class="fas fa-tachometer-alt me-3 w-5 text-center {{ $isDashboardActive ? $activeIconClass : $inactiveIconClass }}"></i>
            Dashboard
        </a>

        {{-- 2. Link Warga Didampingi --}}
        @php $isListWargaActive = request()->routeIs('musahil.list-warga'); @endphp
        <a href="{{ route('musahil.list-warga') }}"
           class="{{ $baseLinkClass }} {{ $isListWargaActive ? $activeLinkClass : $inactiveLinkClass }}"
           @click="if(window.innerWidth < 768) sidebarOpen = false">
            <i class="fas fa-users me-3 w-5 text-center {{ $isListWargaActive ? $activeIconClass : $inactiveIconClass }}"></i>
            Warga Didampingi
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

        {{-- 3. Link Lakukan Absensi --}}
        @php $isAbsensiActive = request()->routeIs('musahil.absensi_ekstra'); @endphp
        <a href="{{ route('musahil.absensi_ekstra') }}"
           class="{{ $baseLinkClass }} {{ $isAbsensiActive ? $activeLinkClass : $inactiveLinkClass }}"
           @click="if(window.innerWidth < 768) sidebarOpen = false">
            <i class="fas fa-camera me-3 w-5 text-center {{ $isAbsensiActive ? $activeIconClass : $inactiveIconClass }}"></i>
            Lakukan Absensi
        </a>

    </nav>

    {{-- Bagian Profil & Pengaturan di Bawah --}}
    <div class="mt-auto shrink-0 border-t border-slate-200 p-4 dark:border-slate-700">
         @php $isPengaturanActive = request()->routeIs('profile.edit'); @endphp
         <a href="{{ route('profile.edit') }}"
           class="{{ $baseLinkClass }} {{ $isPengaturanActive ? $activeLinkClass : $inactiveLinkClass }}"
           @click="if(window.innerWidth < 768) sidebarOpen = false">
            <i class="fas fa-cog me-3 w-5 text-center {{ $isPengaturanActive ? $activeIconClass : $inactiveIconClass }}"></i>
            Profil & Pengaturan
        </a>
    </div>
</aside>