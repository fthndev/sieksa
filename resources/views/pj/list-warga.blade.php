{{-- resources/views/musahil/list-warga.blade.php --}}

{{-- Langsung gunakan layout khusus musahil. --}}
{{-- Asumsi bahwa route ke halaman ini sudah dilindungi agar hanya musahil yang bisa mengakses. --}}
<title>
    List -Warga
</title>
<x-app-layout>

    {{-- Slot untuk Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Warga yang Anda Dampingi') }}
        </h2>
    </x-slot>

    {{-- Slot untuk Konten Utama Halaman --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Judul bagian dalam card --}}
                    <h3 class="text-xl font-bold mb-6 text-center md:text-left">Daftar Dampingan Aktif</h3>

                    @if ($list_dampingi->isEmpty())
                        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-800 p-4 rounded" role="alert">
                            <p class="font-bold">Informasi:</p>
                            <p>Anda belum mendampingi warga manapun saat ini.</p>
                            <p class="mt-2 text-sm text-blue-700">Silakan hubungi administrator jika ada kesalahan atau Anda perlu menambahkan dampingan.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nomor
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            NIM Warga
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Warga
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status Ekstrakurikuler
                                        </th>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Ekstrakurikuler
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Presentase Kehadiran
                                        </th>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Beri Pesan
                                        </th>

                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php $no = 0 @endphp
                                    @foreach ($list_dampingi as $damping)
                                        @php
                                            $absensi_detail_warga = \Illuminate\Support\Facades\DB::table('detail_absensi')
                                                        ->where('id_pengguna', $damping->id_warga)
                                                        ->get();
                                            $absensi_ekstra = \Illuminate\Support\Facades\DB::table('absensi')
                                                        ->where('id_ekstrakurikuler', $damping->id_ekstra_warga)
                                                        ->get();
                                            $ekstra = \Illuminate\Support\Facades\DB::table('ekstrakurikuler')
                                                        ->where('id_ekstrakurikuler', $damping->id_ekstra_warga)
                                                        ->first();
                                            $total_kehadiran_warga = $absensi_detail_warga->count();
                                            $total_absensi_ekstra = $absensi_ekstra->count();
                                            $persentase = 0;
                                            if ($total_absensi_ekstra > 0) {
                                                $persentase = ($total_kehadiran_warga / $total_absensi_ekstra) * 100;
                                                $persentase = number_format($persentase, 2);
                                            }
                                            $no += 1
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $no }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $damping->id_warga }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $damping->nama_warga ?? 'Nama Tidak Ditemukan' }}
                                            </td>
                                            <td>
                                                @if (empty($damping->id_ekstra_warga))
                                                <div class="flex justify-center ">
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-green-800">
                                                         Belum Terdaftar
                                                    </span>
                                                </div>

                                                @else
                                                <div class="flex justify-center ">
                                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                         Terdaftar
                                                    </span>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $ekstra && $ekstra->nama_ekstra ? ucwords($ekstra->nama_ekstra) : 'None' }}
                                            </td>
                                            @php
                                                    $color = 'bg-gray-200 text-gray-800';
                                                    if ($persentase >= 75) {
                                                        $color = 'bg-green-100 text-green-800';
                                                    } elseif ($persentase >= 50) {
                                                        $color = 'bg-yellow-100 text-yellow-800';
                                                    } else {
                                                        $color = 'bg-red-100 text-red-800';
                                                    }
                                                @endphp
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{$color}}">
                                                {{ $persentase}}%
                                            </td>
                                            <td>
                                                <div class="flex justify-center">
                                                    <a href="mailto:{{ $damping->email_warga }}?subject=Pendampingan dari Musahil"
                                                        
                                                       class="text-blue-600 hover:text-blue-900">
                                                        <i class="fa-regular fa-message"></i>   Pesan
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>