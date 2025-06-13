<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Kartu Selamat Datang --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Selamat datang, {{ $user->nama ?? 'Admin' }}!</h2>
                    <p>Anda memiliki hak akses penuh terhadap sistem. Gunakan panel ini untuk mengelola seluruh aspek SIEKSAd.</p>
                </div>
            </div>

            {{-- Kartu Statistik Ringkasan --}}
            @if(isset($statistik))
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="card bg-base-200 text-center p-4">
                    <div class="text-3xl font-bold">{{ $statistik['totalPengguna'] ?? 0 }}</div>
                    <div class="text-sm opacity-70">Total Pengguna</div>
                </div>
                <div class="card bg-base-200 text-center p-4">
                    <div class="text-3xl font-bold">{{ $statistik['totalEkstrakurikuler'] ?? 0 }}</div>
                    <div class="text-sm opacity-70">Total Ekskul</div>
                </div>
                <div class="card bg-base-200 text-center p-4">
                    <div class="text-3xl font-bold">{{ $statistik['totalWarga'] ?? 0 }}</div>
                    <div class="text-sm opacity-70">Total Warga</div>
                </div>
                <div class="card bg-base-200 text-center p-4">
                    <div class="text-3xl font-bold">{{ $statistik['totalMusahil'] ?? 0 }}</div>
                    <div class="text-sm opacity-70">Total Musahil</div>
                </div>
                <div class="card bg-base-200 text-center p-4">
                    <div class="text-3xl font-bold">{{ $statistik['totalPJ'] ?? 0 }}</div>
                    <div class="text-sm opacity-70">Total PJ</div>
                </div>
            </div>
            @endif

            {{-- Panel Manajemen Utama --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title"><i class="fas fa-cogs me-2"></i>Panel Manajemen Utama</h2>
                    <p class="text-sm text-base-content/70 mb-4">Pilih salah satu menu di bawah untuk mulai mengelola data sistem.</p>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        
                        {{-- Link ke Manajemen User --}}
                        <a href="#" {{-- Ganti dengan route manajemen user --}}
                           class="card bg-base-200 hover:bg-base-300 transition-all text-center p-6">
                            <div class="text-4xl text-primary"><i class="fas fa-users-cog"></i></div>
                            <p class="mt-2 font-semibold">Kelola Pengguna</p>
                            <p class="text-xs opacity-60">Tambah, Edit, Hapus Data Warga, Musahil, dan PJ</p>
                        </a>
                        
                        {{-- Link ke Manajemen Ekstrakurikuler --}}
                        <a href="#" {{-- Ganti dengan route manajemen ekskul --}}
                           class="card bg-base-200 hover:bg-base-300 transition-all text-center p-6">
                            <div class="text-4xl text-primary"><i class="fas fa-puzzle-piece"></i></div>
                            <p class="mt-2 font-semibold">Kelola Ekstrakurikuler</p>
                            <p class="text-xs opacity-60">Atur Detail, Jadwal, dan Penanggung Jawab Ekskul</p>
                        </a>
                        
                        {{-- Link ke Manajemen Absensi --}}
                        <a href="#" {{-- Ganti dengan route manajemen absensi --}}
                           class="card bg-base-200 hover:bg-base-300 transition-all text-center p-6">
                            <div class="text-4xl text-primary"><i class="fas fa-calendar-check"></i></div>
                            <p class="mt-2 font-semibold">Kelola Absensi</p>
                            <p class="text-xs opacity-60">Lihat dan Edit Data Kehadiran Semua Ekskul</p>
                        </a>
                        
                        {{-- Link ke Manajemen Materi --}}
                        <a href="#" {{-- Ganti dengan route manajemen materi --}}
                           class="card bg-base-200 hover:bg-base-300 transition-all text-center p-6">
                            <div class="text-4xl text-primary"><i class="fas fa-book-open"></i></div>
                            <p class="mt-2 font-semibold">Kelola Materi</p>
                            <p class="text-xs opacity-60">Unggah dan Atur Materi Pembelajaran</p>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>