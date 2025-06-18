<title>
    Dashboard - Musahil
</title>
<x-app-musahil-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Dashboard Musahil') }}
        </h2>
    </x-slot>

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                toast: true,
                position: 'top-end',    // pojok kanan atas
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        });
    </script>
    @elseif (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        });
    </script>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-slate-900 dark:text-slate-100">
                    <h3 class="text-lg font-medium">
                        Selamat datang di Panel Musahil, {{ $user->nama ?? 'Musahil' }}!
                    </h3>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                        Berikut adalah daftar warga yang Anda dampingi.
                    </p>
                </div>
            </div>

            {{-- Daftar Warga yang Didampingi --}}

            {{-- Kartu Aksi Cepat bisa tetap ada atau disesuaikan --}}
            
            {{-- Card untuk Ekstrakurikuler yang Anda Ikuti (Utama) --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-700 dark:text-red-400 mb-3 flex items-center">
                        <i class="fas fa-award me-3 opacity-80"></i>
                        Ekstrakurikuler Utama Anda
                    </h3>
                    @php
                        $kuota = $ekstrakurikulerYangDiikuti->kuota ?? 0;
                        $jumlahPeserta = $ekstrakurikulerYangDiikuti && $ekstrakurikulerYangDiikuti->pesertas ? $ekstrakurikulerYangDiikuti->pesertas->count() : 0;
                        $tersisa = $kuota - $jumlahPeserta;
                    @endphp
                    @if ($ekstrakurikulerYangDiikuti)
                        <div class="space-y-2 text-sm text-slate-700 dark:text-slate-300">
                            <p><strong class="font-medium text-slate-800 dark:text-slate-100">Nama Kegiatan:</strong> {{ $ekstrakurikulerYangDiikuti->nama_ekstra }}</p>
                            <p><strong class="font-medium text-slate-800 dark:text-slate-100">Jadwal:</strong> Setiap hari {{ $ekstrakurikulerYangDiikuti->hari ?: '-' }}, pukul {{ $ekstrakurikulerYangDiikuti->jam ? \Carbon\Carbon::parse($ekstrakurikulerYangDiikuti->jam)->format('H:i') : '-' }}</p>
                            @if(isset($ekstrakurikulerYangDiikuti->kuota)) {{-- Menggunakan 'kuota' sesuai skema Anda --}}
                                <p><strong class="font-medium text-slate-800 dark:text-slate-100">Kuota Ekskul Ini:</strong> {{ $ekstrakurikulerYangDiikuti->kuota }} peserta, Tersisa {{$tersisa}}</p>
                            @endif
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
                                @php
                                    $kuota = $ekskul->kuota ?? 0;
                                    $jumlahPeserta = $ekskul && $ekskul->pesertas ? $ekskul->pesertas->count() : 0;
                                    $kuota_ekstra_now = $kuota - $jumlahPeserta;
                                @endphp
                                <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-lg border border-slate-200 dark:border-slate-700 flex flex-col justify-between shadow hover:shadow-lg transition-shadow duration-200">
                                    <div>
                                        <h4 class="font-semibold text-md text-slate-800 dark:text-slate-100 mb-1">{{ ucwords($ekskul->nama_ekstra) }}</h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">
                                            <i class="fas fa-calendar-alt me-1 opacity-70"></i> {{ $ekskul->hari ?: 'Belum terjadwal' }}
                                            @if($ekskul->jam)
                                            , <i class="fas fa-clock me-1 opacity-70"></i> {{ \Carbon\Carbon::parse($ekskul->jam)->format('H:i') }}
                                            @endif
                                        </p>
                                        @if(isset($ekskul->kuota))
                                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2 flex items-center gap-2">
                                                <i class="fas fa-users me-1 opacity-70"></i>
                                                <span>Kuota: {{ $ekskul->kuota }}</span>
                                                <span class="text-green-600 dark:text-green-400">Tersisa: {{ $kuota_ekstra_now }}</span>
                                            </p>
                                        @endif

                                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed mb-3 min-h-[3em]">{{ Str::limit($ekskul->ketrangan ?: 'Tidak ada deskripsi tambahan.', 80) }}</p>
                                    </div>                      
                                    <div class="mt-auto pt-3 border-t border-slate-200 dark:border-slate-600 flex flex-wrap gap-2 flex-col sm:flex-row">
                                        <a href=""
                                            @click.prevent="detailModal = true; detailData = {{ $ekskul->toJson() }}"
                                            class="inline-flex items-center justify-center px-3 py-2 bg-sky-600 dark:bg-sky-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-100 uppercase tracking-widest hover:bg-sky-700 dark:hover:bg-sky-600 focus:bg-sky-700 dark:focus:bg-sky-600 active:bg-sky-800 dark:active:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                                            <i class="fas fa-eye me-2"></i> Lihat Detail
                                        </a>
                                        @if(empty($user->id_ekstrakurikuler))
                                        <a href="#"
                                            @click.prevent='showModal = true; daftarUrl = "{{ route('musahil.pendaftaran_ekstra', ['ekskul' => $ekskul->id_ekstrakurikuler]) }}"'
                                            class="inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-emerald-700 bg-emerald-100 dark:bg-emerald-600/40 dark:text-emerald-300 rounded-md hover:bg-emerald-200 dark:hover:bg-emerald-500 transition border border-transparent">
                                            <i class="fas fa-check-circle me-2"></i> Daftar Disini!
                                        </a>

                                        @elseif($user->id_ekstrakurikuler != $ekskul->id_ekstrakurikuler)
                                        <a href="#"
                                            onclick="return false;"
                                            class="inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-emerald-700 bg-emerald-100 dark:bg-emerald-600/40 dark:text-emerald-300 rounded-md hover:bg-emerald-200 dark:hover:bg-emerald-500 transition border border-transparent opacity-60 cursor-not-allowed disabled">
                                            <i class="fas fa-check-circle me-2"></i> Daftar Disini!
                                        </a>

                                        @else
                                        <a href="#"
                                            onclick="return false;"
                                            class="inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-emerald-700 bg-emerald-100 dark:bg-emerald-600/40 dark:text-emerald-300 rounded-md hover:bg-emerald-200 dark:hover:bg-emerald-500 transition border border-transparent opacity-60 cursor-not-allowed disabled">
                                            <i class="fas fa-check-circle me-2"></i> Telah terdaftar!
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
    

    <div x-show="showModal"
        style="display: none;"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
        <div @click.away="showModal = false"
            class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg max-w-md w-full">
            <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-4">Konfirmasi Pendaftaran</h2>
            <p class="text-slate-600 dark:text-slate-300 mb-6">Apakah Anda yakin ingin mendaftar ke ekstrakurikuler ini?</p>
            <div class="flex justify-end gap-3">
                <button @click="showModal = false"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded text-sm text-gray-800 dark:text-gray-100 hover:bg-gray-400 dark:hover:bg-gray-500">
                    Batal
                </button>
                <a :href="daftarUrl"
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded transition">
                    Ya, Daftar
                </a>
            </div>
        </div>
    </div>

    <div x-show="detailModal"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm bg-black/50">

        <div @click.away="detailModal = false"
            class="relative bg-white dark:bg-slate-800 p-6 rounded-xl shadow-2xl max-w-md w-full border border-transparent bg-clip-padding backdrop-filter backdrop-blur-md"
            style="border-image: linear-gradient(135deg, #7f5af0, #00c896) 1;">

            <!-- Dekorasi ikon -->
            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-violet-500 to-teal-400 w-10 h-10 rounded-full flex items-center justify-center shadow-md">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h2 class="text-lg font-bold text-center text-slate-800 dark:text-white mb-4 mt-4"
                x-text="detailData.nama_ekstra.toUpperCase()"></h2>

            <div class="text-slate-600 dark:text-slate-300 text-sm space-y-2">
                <p><strong>Hari:</strong> <span x-text="detailData.hari ?? '-'"></span></p>
                <p><strong>Jam:</strong> <span x-text="detailData.jam ?? '-'"></span></p>
                <p><strong>Kuota:</strong> <span x-text="detailData.kuota ?? '-'"></span></p>
                <p><strong>Deskripsi:</strong></p>
                <p x-text="detailData.ketrangan ?? 'Tidak ada deskripsi.'" class="text-justify"></p>
            </div>

            <div class="mt-6 text-right">
                <button @click="detailModal = false"
                        class="px-4 py-2 bg-gradient-to-r from-slate-300 to-slate-400 dark:from-slate-700 dark:to-slate-600 text-slate-800 dark:text-white rounded-lg hover:brightness-110 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</x-app-musahil-layout>