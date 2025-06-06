{{-- resources/views/layouts/sidebar.blade.php --}}
<aside
    class="w-64 bg-slate-100 dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 flex flex-col
           fixed inset-y-0 left-0 z-40 {{-- Mobile: Fixed overlay, z-index di atas backdrop --}}
           transform transition-transform duration-300 ease-in-out
           md:sticky md:top-0 md:h-screen md:overflow-y-auto md:shrink-0 md:translate-x-0 {{-- Desktop: Sticky atau bagian normal dari flex, selalu terlihat --}}"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'" {{-- Kontrol visibility --}}
    x-cloak>

    <div class="h-16 flex items-center justify-between px-4 border-b border-slate-200 dark:border-slate-700 shrink-0">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-red-700 dark:text-red-500">
            SIEKSAd Panel
        </a>
        {{-- Tombol Close Sidebar (hanya untuk mobile) --}}
        <button @click="sidebarOpen = false" class="md:hidden text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 p-1 -mr-1">
            <i class="fas fa-times text-xl"></i>
            <span class="sr-only">Tutup menu</span>
        </button>
    </div>

    <nav class="flex-grow p-4 space-y-1 overflow-y-auto">
        {{-- Logika untuk menentukan route aktif --}}
        @php
            $currentRoute = request()->route() ? request()->route()->getName() : '';
        @endphp

        {{-- Dashboard Link --}}
        @php
            $isDashboardActive = ($currentRoute == 'dashboard');
            $dashboardLinkClasses = 'flex items-center px-3 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 group ';
            $dashboardLinkClasses .= $isDashboardActive
                ? 'bg-red-100 dark:bg-red-700/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 font-semibold'
                : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-slate-100';
            $dashboardIconClasses = $isDashboardActive
                ? 'text-red-600 dark:text-red-400'
                : 'text-slate-500 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200';
        @endphp
        <a href="{{ route('dashboard') }}"
           class="{{ $dashboardLinkClasses }}"
           @click="if(window.innerWidth < 768) sidebarOpen = false" {{-- Tutup sidebar di mobile saat link diklik --}}>
            <i class="fas fa-tachometer-alt w-5 h-5 me-3 {{ $dashboardIconClasses }} transition-colors duration-150"></i>
            Dashboard
        </a>

        {{-- Warga Didampingi Link --}}
        @php
            $isListWargaActive = ($currentRoute == 'musahil.list-warga'); // Sesuaikan dengan nama route Anda
            $listWargaLinkClasses = 'flex items-center px-3 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 group ';
            $listWargaLinkClasses .= $isListWargaActive
                ? 'bg-red-100 dark:bg-red-700/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 font-semibold'
                : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-slate-100';
            $listWargaIconClasses = $isListWargaActive
                ? 'text-red-600 dark:text-red-400'
                : 'text-slate-500 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200';
        @endphp
        <a href="{{ route('musahil.list-warga') }}"
           class="{{ $listWargaLinkClasses }}"
           @click="if(window.innerWidth < 768) sidebarOpen = false">
            <i class="fas fa-users w-5 h-5 me-3 {{ $listWargaIconClasses }} transition-colors duration-150"></i> {{-- Menggunakan ikon fa-users --}}
            Warga Didampingi
        </a>

        {{-- Ekstrakurikuler Dropdown (dengan penyesuaian @click untuk mobile) --}}
        @php $isEkstrakurikulerActive = Str::startsWith($currentRoute, 'ekstrakurikuler.'); @endphp
        <div x-data="{ open: {{ $isEkstrakurikulerActive ? 'true' : 'false' }} }">
            @php
                $ekstrakurikulerLinkClasses = 'w-full flex items-center justify-between px-3 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 group ';
                $ekstrakurikulerLinkClasses .= ($isEkstrakurikulerActive && !Str::contains($currentRoute, '.')) // Jika parent aktif tapi bukan anak, ini akan selalu false karena kita punya anak route
                    ? 'bg-red-100 dark:bg-red-700/20 text-red-700 dark:text-red-400 font-semibold'
                    : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-slate-100';
                $ekstrakurikulerIconClasses = $isEkstrakurikulerActive
                    ? 'text-red-600 dark:text-red-400'
                    : 'text-slate-500 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200';
            @endphp
            <button @click="open = !open"
                    class="{{ $ekstrakurikulerLinkClasses }} text-left">
                <span class="flex items-center">
                    <i class="fas fa-puzzle-piece w-5 h-5 me-3 {{ $ekstrakurikulerIconClasses }} transition-colors duration-150"></i>
                    Ekstrakurikuler
                </span>
                <i class="fas w-4 h-4 transform transition-transform duration-200 text-slate-500 group-hover:text-slate-700"
                   :class="{'fa-chevron-down': !open, 'fa-chevron-up': open}"></i>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="mt-1 ms-4 ps-3 border-l-2 border-slate-200 dark:border-slate-700 space-y-1" x-cloak>
                @php
                    $kelasDummy = [
                        ['nama' => 'Klub Robotik', 'icon' => 'fa-cogs', 'route_name' => 'ekstrakurikuler.robotik'],
                        ['nama' => 'Pramuka', 'icon' => 'fa-hiking', 'route_name' => 'ekstrakurikuler.pramuka'],
                        ['nama' => 'Musik', 'icon' => 'fa-music', 'route_name' => 'ekstrakurikuler.musik'],
                        // ... data dummy lainnya ...
                    ];
                @endphp
                @foreach($kelasDummy as $kelas)
                    @php
                        $isKelasActive = ($currentRoute == $kelas['route_name']);
                        $kelasLinkClasses = 'flex items-center w-full ps-3 pe-2 py-2 rounded-md text-sm transition-colors duration-150 group ';
                        $kelasLinkClasses .= $isKelasActive
                            ? 'bg-red-100 dark:bg-red-700/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 -ml-[14px] pl-[10px] font-semibold'
                            : 'text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-slate-100';
                        $kelasIconClasses = $isKelasActive
                            ? 'text-red-600 dark:text-red-400'
                            : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-600 dark:group-hover:text-slate-300';
                    @endphp
                    <a href="#" {{-- Ganti dengan route($kelas['route_name']) setelah route diatur --}}
                       class="{{ $kelasLinkClasses }}"
                       @click="if(window.innerWidth < 768) sidebarOpen = false">
                        <i class="fas {{ $kelas['icon'] }} w-4 h-4 me-2.5 {{ $kelasIconClasses }} transition-colors duration-150 opacity-80"></i>
                        {{ $kelas['nama'] }}
                    </a>
                @endforeach
            </div>
        </div>
        {{-- ... Sisa menu sidebar Anda ... --}}
    </nav>

    <div class="p-4 border-t border-slate-200 dark:border-slate-700 mt-auto shrink-0">
        @php
            $isPengaturanActive = ($currentRoute == 'settings.index'); // Ganti dengan nama route Anda
            $pengaturanLinkClasses = 'flex items-center px-3 py-2.5 rounded-md text-sm font-medium transition-colors duration-150 group ';
            $pengaturanLinkClasses .= $isPengaturanActive
                ? 'bg-red-100 dark:bg-red-700/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 font-semibold'
                : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-slate-100';
            $pengaturanIconClasses = $isPengaturanActive
                ? 'text-red-600 dark:text-red-400'
                : 'text-slate-500 dark:text-slate-400 group-hover:text-slate-700 dark:group-hover:text-slate-200';
        @endphp
        <a href="#" {{-- Ganti dengan route pengaturan Anda --}}
           class="{{ $pengaturanLinkClasses }}"
            @click="if(window.innerWidth < 768) sidebarOpen = false">
            <i class="fas fa-cog w-5 h-5 me-3 {{ $pengaturanIconClasses }} transition-colors duration-150"></i>
            Pengaturan
        </a>
    </div>
</aside>