<title>
    Detail Kehadiran
</title>
<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
            <div>
                <h2 class="font-semibold text-xl text-base-content leading-tight">
                    Detail Absensi: {{ $absensi->ekstrakurikuler->nama_ekstra }}
                </h2>
                <p class="text-sm text-base-content/70">
                    Pertemuan ke-{{ $absensi->pertemuan }} | Tanggal: {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') }}
                </p>
            </div>
            <a href="{{ route('pj.absensi.index') }}" {{-- Mengarah ke halaman manajemen absensi PJ --}}
               class="btn btn-sm btn-ghost bg-red-400">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Manajemen Absensi
            </a>
        </div>
    </x-slot>
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
        <div class="h-[50px] p-4 space-y-4 z-[100]">
            {{-- Notifikasi Sukses --}}
            @if(session('status'))
            <div id="alert-success" role="alert" class="alert alert-success shadow-lg mb-6 opacity-0 transition-opacity duration-500 ease-in-out">
                <div>
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
            @endif
        </div>

            <div class="card bg-base-100 shadow-xl mt-10">
                <div class="card-body">
                    {{-- ... (Bagian Materi Pembahasan tetap sama) ... --}}

                    <h3 class="card-title mt-6">Daftar Kehadiran Peserta</h3>
                    <p class="text-sm text-base-content/70 mb-1">Anda dapat mengubah status kehadiran setiap peserta secara manual jika diperlukan.</p>
                    {{-- Tombol Reporting --}}
                    <div class="flex justify-end mt-4 gap-2">
                        <a href="{{route('pj.detail_absensi_table', ['absensi' => $absensi->id_absensi, 'ekstra' => $absensi->id_ekstrakurikuler])}}"
                            class="btn btn-sm btn-outline btn-success">
                            <i class="fas fa-file-excel me-2"></i> Report Excel
                        </a>
                        <a href="{{route('pj.detail_absensi_table_pdf', ['absensi' => $absensi->id_absensi, 'ekstra' => $absensi->id_ekstrakurikuler])}}" class="btn btn-sm btn-outline btn-info">
                            <i class="fas fa-print me-2"></i> Report PDF
                        </a>
                    </div>
                    
                    @if ($absensi->detailAbsensi->isNotEmpty())
                        <div class="overflow-x-auto mt-4">
                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama Peserta</th>
                                        <th class="w-1/4">Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absensi->detailAbsensi as $index => $detail)
                                    <tr class="hover">
                                        <th>{{ $index + 1 }}</th>
                                        <td>{{ $detail->pengguna->nim }}</td>
                                        <td>{{ $detail->pengguna->nama }}</td>
                                        <td>
                                            {{-- Form untuk mengupdate status --}}
                                            <form action="{{ route('pj.absensi.update_status', [$detail, $detail->pengguna->nim]) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')
                                                
                                                @php
                                                    $statusSekarang = strtolower($detail->status);
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
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-base-content/70 mt-2">Belum ada data kehadiran untuk sesi ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertBox = document.getElementById('alert-success');
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.remove('opacity-0');
                alertBox.classList.add('opacity-100');
            }, 100);

            setTimeout(() => {
                alertBox.classList.add('opacity-0'); // untuk animasi fade out
                setTimeout(() => alertBox.remove(), 500); // hapus elemen setelah fade out
            }, 2000); // tampil selama 3 detik
        }
    });
</script>
</x-app-layout>