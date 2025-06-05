{{-- resources/views/warga/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Dashboard Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Kartu Selamat Datang --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-slate-900 dark:text-slate-100">
                    <h3 class="text-lg font-medium">
                        Selamat datang, {{ $user->nama ?? 'Warga' }}!
                    </h3>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                        Lihat informasi ekstrakurikuler Anda dan pilihan kegiatan lainnya di bawah ini.
                    </p>
                </div>
            </div>

            {{-- Card untuk Ekstrakurikuler yang Anda Ikuti (Utama) --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-700 dark:text-red-400 mb-3 flex items-center">
                        <i class="fas fa-award me-3 opacity-80"></i>
                        Ekstrakurikuler Utama Anda
                    </h3>
                    @if ($ekstrakurikulerYangDiikuti)
                        <div class="space-y-2 text-sm text-slate-700 dark:text-slate-300">
                            <p><strong class="font-medium text-slate-800 dark:text-slate-100">Nama Kegiatan:</strong> {{ $ekstrakurikulerYangDiikuti->nama_ekstra }}</p>
                            <p><strong class="font-medium text-slate-800 dark:text-slate-100">Jadwal:</strong> Setiap hari {{ $ekstrakurikulerYangDiikuti->hari ?: '-' }}, pukul {{ $ekstrakurikulerYangDiikuti->jam ? \Carbon\Carbon::parse($ekstrakurikulerYangDiikuti->jam)->format('H:i') : '-' }}</p>
                            @if(isset($ekstrakurikulerYangDiikuti->kouta)) {{-- Menggunakan 'kouta' sesuai skema Anda --}}
                                <p><strong class="font-medium text-slate-800 dark:text-slate-100">Kuota Ekskul Ini:</strong> {{ $ekstrakurikulerYangDiikuti->kouta }} peserta</p>
                            @endif
                            <p><strong class="font-medium text-slate-800 dark:text-slate-100">Deskripsi:</strong></p>
                            <p class="pl-1">{{ $ekstrakurikulerYangDiikuti->ketrangan ?: 'Tidak ada deskripsi.' }}</p> {{-- Menggunakan 'ketrangan' sesuai skema --}}
                            {{-- Tambahkan tombol atau link aksi lain jika perlu, misalnya "Lihat Absensi Saya" --}}
                            {{-- <a href="#" class="mt-3 inline-block text-sm text-red-600 dark:text-red-500 hover:underline">Lihat Absensi Saya</a> --}}
                        </div>
                    @else
                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                            <i class="fas fa-info-circle me-3 text-lg"></i>
                            <p>Anda saat ini tidak terdaftar pada ekstrakurikuler utama. Silakan pilih dari daftar di bawah.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Card untuk Daftar Ekstrakurikuler yang Tersedia --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-700 dark:text-red-400 mb-4 flex items-center">
                        <i class="fas fa-th-list me-3 opacity-80"></i>
                        Pilihan Ekstrakurikuler Tersedia
                    </h3>
                    @if ($semuaEkstrakurikuler && $semuaEkstrakurikuler->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($semuaEkstrakurikuler as $ekskul)
                                <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-lg border border-slate-200 dark:border-slate-700 flex flex-col justify-between shadow hover:shadow-lg transition-shadow duration-200">
                                    <div>
                                        <h4 class="font-semibold text-md text-slate-800 dark:text-slate-100 mb-1">{{ $ekskul->nama_ekstra }}</h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                                            <i class="fas fa-calendar-alt me-1 opacity-70"></i> {{ $ekskul->hari ?: 'Belum terjadwal' }}
                                            @if($ekskul->jam)
                                            , <i class="fas fa-clock me-1 opacity-70"></i> {{ \Carbon\Carbon::parse($ekskul->jam)->format('H:i') }}
                                            @endif
                                        </p>
                                        @if(isset($ekskul->kouta))
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">
                                                <i class="fas fa-users me-1 opacity-70"></i> Kuota: {{ $ekskul->kouta }}
                                            </p>
                                        @endif
                                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed mb-3 min-h-[3em]">{{ Str::limit($ekskul->ketrangan ?: 'Tidak ada deskripsi tambahan.', 80) }}</p>
                                    </div>
                                    <div class="mt-auto pt-3 border-t border-slate-200 dark:border-slate-600">
                                        @if ($ekstrakurikulerYangDiikuti && $ekstrakurikulerYangDiikuti->id_ekstrakulikuler == $ekskul->id_ekstrakulikuler)
                                            <span class="inline-flex items-center justify-center w-full px-3 py-2 text-xs font-medium text-emerald-700 bg-emerald-100 dark:bg-emerald-600/40 dark:text-emerald-300 rounded-md">
                                                <i class="fas fa-check-circle me-2"></i> Anda Mengikuti Ini
                                            </span>
                                        @elseif (isset($ekskul->kouta) && $ekskul->kouta !== null && $ekskul->kouta <= 0)
                                            <span class="inline-flex items-center justify-center w-full px-3 py-2 text-xs font-medium text-slate-500 bg-slate-200 dark:bg-slate-600 dark:text-slate-400 rounded-md">
                                                <i class="fas fa-times-circle me-2"></i> Kuota Penuh
                                            </span>
                                        @else
                                            <a href="{{ route('ekstrakurikuler.detail', ['ekstrakurikuler' => $ekskul->id_ekstrakulikuler]) }}" {{-- Menggunakan id_ekstrakulikuler untuk parameter --}}
                                               class="inline-flex items-center justify-center w-full px-3 py-2 bg-sky-600 dark:bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-100 uppercase tracking-widest hover:bg-sky-700 dark:hover:bg-sky-600 focus:bg-sky-700 dark:focus:bg-sky-600 active:bg-sky-800 dark:active:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                                                <i class="fas fa-eye me-2"></i> Lihat Detail
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-600 dark:text-slate-400">Saat ini belum ada pilihan ekstrakurikuler yang tersedia.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>