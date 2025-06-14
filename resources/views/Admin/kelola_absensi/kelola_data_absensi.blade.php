<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="font-semibold text-xl text-base-content leading-tight text-center md:text-left">
                Kelola Absensi Ekstrakurikuler {{ucwords($ekskul->nama_ekstra)}}
            </h2>
            <div class="flex justify-end md:justify-end">
                <a href="{{route('admin.daftar_absensi_ekstra')}}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
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
    @endif
    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('admin.kelola_absensi_member', $ekskul->id_ekstrakurikuler) }}" class="mb-6">
            <div class="flex flex-col md:flex-row gap-2">
                    <input type="text" name="search" placeholder="Cari nama pertemuan atau status.." class="input input-bordered w-full" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($data_absensi as $list_absensi)
                    <div class="bg-white dark:bg-slate-800 shadow-sm border border-gray-200 dark:border-slate-700 rounded-lg p-4 transition duration-200 hover:shadow-md">
                        <div class="mb-2 text-sm text-gray-500 dark:text-gray-400 bg-purple-800 py-3 rounded-lg text-white flex justify-center shadow-md">
                            Pertemuan Ke-{{ $list_absensi->pertemuan }}
                        </div>
                        <div class="text-base font-semibold text-gray-800 dark:text-white">
                           @php
                                $statusColor = [
                                    'open' => 'text-green-600',
                                    'closed' => 'text-red-600',
                                    'default' => 'text-gray-600',
                                ];
                            @endphp
                            Status: 
                            <span class="font-medium {{$statusColor[$list_absensi->status] ?? 'text-gray-600'}}">
                                {{ ucfirst($list_absensi->status) }}
                            </span>
                        </div>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                            Tanggal: {{ \Carbon\Carbon::parse($list_absensi->tanggal)->format('d F Y') }}
                            
                        </div>
                        <div class="flex items-end justify-end max-w-full">
                            <a href="{{route('admin.list_absensi_member', $list_absensi->id_absensi)}}"
                                class="btn btn-primary btn-sm mt-5 w-full sm:w-auto">
                            <i class="fas fa-arrow-right me-2"></i> Lihat Detail
                        </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white dark:bg-slate-800 shadow rounded-xl p-6 text-center">
                        <i class="fas fa-info-circle text-4xl text-sky-500 mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">Belum Ada Data</h3>
                        <p class="text-gray-500">Belum ada daftar absensi ekstrakurikuler di sistem.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>