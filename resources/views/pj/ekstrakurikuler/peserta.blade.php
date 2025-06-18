{{-- resources/views/pj/ekstrakurikuler/peserta.blade.php --}}
<title>
    Peserta - {{ $ekskul->nama_ekstra }}
</title>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                Daftar Peserta: {{ $ekskul->nama_ekstra }}
            </h2>
            <a href="{{ route('pj.dashboard') }}" class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold rounded-md hover:bg-slate-300 dark:hover:bg-slate-600 transition">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard PJ
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                            Ekstrakurikuler: {{ $ekskul->nama_ekstra }}
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            Jadwal: {{ $ekskul->hari ?: '-' }}, Pukul {{ $ekskul->jam ? \Carbon\Carbon::parse($ekskul->jam)->format('H:i') : '-' }}
                        </p>
                    </div>

                    @if ($listPeserta && $listPeserta->count() > 0)
                        <div class="overflow-x-auto mt-6">
                            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-slate-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase">No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase">NIM</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase">Nama Peserta</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase">Telepon</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-300 uppercase">Role</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                                    @foreach ($listPeserta as $index => $peserta)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">{{ $peserta->nim }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-slate-100">{{ $peserta->nama }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">{{ $peserta->email ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">{{ $peserta->telepon ?? '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-slate-700 dark:text-slate-300">{{ $peserta->role ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">
                            <i class="fas fa-info-circle me-2"></i>Belum ada peserta yang terdaftar untuk ekstrakurikuler ini.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>