<x-app-layout>
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
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-700 dark:text-red-400 mb-4 flex items-center">
                        <i class="fas fa-users me-3 opacity-80"></i>
                        Warga yang Anda Dampingi
                    </h3>
                    @if ($listWargaDidampingi && $listWargaDidampingi->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                <thead class="bg-slate-50 dark:bg-slate-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">
                                            NIM
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">
                                            Nama Warga
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                                    @foreach ($listWargaDidampingi as $warga)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300">
                                                {{ $warga->nim }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-slate-100">
                                                {{ $warga->nama }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300">
                                                {{ $warga->email ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="#" {{-- Ganti dengan route detail warga atau aksi lain --}}
                                                   class="text-red-600 hover:text-red-800 dark:text-red-500 dark:hover:text-red-400">
                                                   Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                            <i class="fas fa-info-circle me-3 text-lg"></i>
                            <p>Anda saat ini belum mendampingi warga.</p>
                        </div>
                    @endif
                </div>
            </div>

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
</x-app-layout>