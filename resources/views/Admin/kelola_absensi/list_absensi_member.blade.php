<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="font-semibold text-xl text-base-content leading-tight text-center md:text-left">
                Daftar Absensi Ekstrakurikuler {{ ucwords($ekskul->nama_ekstra) }} Pertemuan Ke - {{ $id_ekskul->pertemuan }}
            </h2>

            <div class="flex justify-end md:justify-end">
                <a href="{{ route('admin.kelola_absensi_member', $id_ekskul->id_ekstrakurikuler) }}" 
                class="btn btn-primary w-fit md:w-auto">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">                
            <form method="GET" action="{{ route('admin.kelola_absensi_member_detail',  $id_ekskul->id_absensi) }}" class="mb-6">
                <div class="flex flex-col md:flex-row gap-2">
                        <input type="text" name="search" placeholder="Cari nama atau NIM..." class="input input-bordered w-full" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex flex-col md:flex-row gap-2 mb-4 justify-end">
                        <form action="{{ route('admin.clear_absensi_peserta', $id_ekskul->id_absensi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua data absensi?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error">
                                <i class="fas fa-trash mr-1"></i> Hapus Semua
                            </button>
                        </form>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Status Kehadiran</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody >
                                @forelse ($detil_absensi as $absensi)
                                <tr>
                                    <td>{{$absensi->id_pengguna}}</td>
                                    <td>{{$absensi->pengguna->nama}}</td>
                                    <td>
                                        {{-- Form untuk mengupdate status --}}
                                        <form action="{{ route('admin.absensi_update_status_admin', [$absensi, $absensi->pengguna->nim]) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            
                                            @php
                                                $statusSekarang = strtolower($absensi->status);
                                                $selectClass = match ($statusSekarang) {
                                                    'hadir' => 'select-success',
                                                    'izin', 'sakit' => 'select-info',
                                                    'absen', 'alpha' => 'select-error',
                                                    default => 'select-bordered',
                                                };

                                                $BorderClass = match ($statusSekarang) {
                                                    'hadir' => 'select-success',
                                                    'izin', 'sakit' => 'select-info',
                                                    'absen', 'alpha' => 'select-error',
                                                    default => 'select-bordered',
                                                };
                                            @endphp
                                            
                                            <select name="status" class="select select-sm {{ $selectClass }} w-full max-w-xs h-10">
                                                <option value="hadir" @selected($statusSekarang == 'hadir')>Hadir</option>
                                                <option value="sakit" @selected($statusSekarang == 'sakit')>Sakit</option>
                                                <option value="izin" @selected($statusSekarang == 'izin')>Izin</option>
                                                <option value="alpha" @selected($statusSekarang == 'alpha' || $statusSekarang == 'absen')>Alpha</option>
                                            </select>

                                            <button type="submit" class="btn btn-sm btn-ghost">
                                                <i class="fas fa-save text-success"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="space-x-2 text-center">
                                        <form action="{{route('admin.hapus_absensi_peserta', $absensi->id_detail_absensi)}}" method="POST" class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white text-sm font-semibold rounded hover:bg-red-700 transition duration-200">
                                                <i class="fas fa-trash-alt mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center p-4">Tidak ada data yang ditemukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>