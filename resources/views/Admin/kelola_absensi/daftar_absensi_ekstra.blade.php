<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                Kelola Absensi Ekstrakurikuler
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div role="alert" class="alert alert-success shadow-lg mb-6">
                <div><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($listEkstrakurikuler as $ekskul)
                    <div class="bg-white dark:bg-slate-800 shadow-md rounded-2xl p-5 transition-all duration-300 hover:shadow-xl border border-gray-100 dark:border-slate-700">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-red-100 dark:bg-red-900/30 text-red-500 rounded-full w-20 h-20 flex items-center justify-center mb-4">
                                <i class="fas fa-shapes text-3xl"></i>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-1">
                                Absensi {{ ucwords($ekskul->nama_ekstra) }}
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Jadwal: {{ $ekskul->hari ?: 'N/A' }}
                                @if($ekskul->jam), Pukul {{ \Carbon\Carbon::parse($ekskul->jam)->format('H:i') }} @endif
                            </p>

                            <div class="flex flex-wrap justify-center gap-2 text-sm mt-4">
                                <span class="badge badge-outline flex items-center gap-2">
                                    <i class="fas fa-users"></i> {{ $ekskul->pesertas_count }}
                                </span>
                                <span class="badge badge-outline flex items-center gap-2">
                                    <i class="fas fa-user-shield"></i> {{ $ekskul->penanggungJawab->nama ?? 'N/A' }}
                                </span>
                            </div>

                            <a href="{{ route('admin.kelola_absensi_member', $ekskul->id_ekstrakurikuler) }}"
                            class="btn btn-primary btn-sm mt-5 w-full sm:w-auto">
                                <i class="fas fa-arrow-right me-2"></i> Kelola Absensi
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white dark:bg-slate-800 shadow rounded-xl p-6 text-center">
                        <i class="fas fa-info-circle text-4xl text-sky-500 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Belum Ada Data</h3>
                        <p class="text-gray-500">Belum ada data ekstrakurikuler di sistem. Silakan tambahkan yang baru.</p>
                    </div>
                @endforelse
            </div>
            
            {{-- Navigasi Paginasi --}}
            <div class="mt-8">
                {{ $listEkstrakurikuler->links() }}
            </div>
        </div>
    </div>
</x-app-layout>