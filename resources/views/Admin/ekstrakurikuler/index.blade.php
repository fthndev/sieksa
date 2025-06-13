<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                Kelola Ekstrakurikuler
            </h2>
            <a href="#" {{-- Ganti dengan route('admin.ekstrakurikuler.create') nanti --}}
               class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div role="alert" class="alert alert-success shadow-lg mb-6">
                <div><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($listEkstrakurikuler as $ekskul)
                    <div class="card card-side bg-base-100 shadow-xl transition-all duration-300 hover:shadow-2xl">
                        <figure class="w-1/3 bg-slate-100 dark:bg-slate-800 hidden sm:flex items-center justify-center">
                            <i class="fas fa-shapes text-7xl text-red-500/20"></i>
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">{{ ucwords($ekskul->nama_ekstra) }}</h2>
                            <p class="text-sm text-base-content/70">
                                Jadwal: {{ $ekskul->hari ?: 'N/A' }}
                                @if($ekskul->jam), Pukul {{ \Carbon\Carbon::parse($ekskul->jam)->format('H:i') }} @endif
                            </p>
                            <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm mt-2">
                                <div class="tooltip" data-tip="Jumlah Peserta Terdaftar">
                                    <span class="badge badge-lg badge-outline"><i class="fas fa-users me-2"></i>{{ $ekskul->pesertas_count }}</span>
                                </div>
                                <div class="tooltip" data-tip="Penanggung Jawab">
                                    <span class="badge badge-lg badge-outline"><i class="fas fa-user-shield me-2"></i>{{ $ekskul->penanggungJawab->nama ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="card-actions justify-end mt-4">
                                <a href="{{ route('admin.ekstrakurikuler.members', $ekskul) }}"
                                   class="btn btn-primary">
                                    Kelola Anggota
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card bg-base-100 shadow-xl md:col-span-2">
                        <div class="card-body items-center text-center">
                            <i class="fas fa-info-circle text-4xl text-sky-500 mb-4"></i>
                            <h3 class="card-title">Belum Ada Data</h3>
                            <p>Belum ada data ekstrakurikuler di sistem. Silakan tambahkan yang baru.</p>
                        </div>
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