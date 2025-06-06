<x-app-musahil-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Dashboard Musahil') }}
        </h2>
    </x-slot>

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
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-700 dark:text-red-400 mb-4 flex items-center">
                        <i class="fas fa-rocket me-3 opacity-80"></i>
                        Aksi Cepat Lainnya
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                         <a href="#" class="flex flex-col items-center justify-center p-4 bg-slate-50 dark:bg-slate-700/50 hover:bg-red-50 dark:hover:bg-red-700/20 rounded-lg transition-colors duration-150 group border border-slate-200 dark:border-slate-700">
                            <i class="fas fa-calendar-check fa-2x mb-2 text-red-600 dark:text-red-500 group-hover:text-red-700 dark:group-hover:text-red-400"></i>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-red-700 dark:group-hover:text-red-400 text-center">Kelola Absensi Warga</span>
                        </a>
                        {{-- Tombol aksi lainnya --}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-musahil-layout>