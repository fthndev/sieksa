<x-app-layout>
    <x-slot name="header">
        {{-- Menggunakan flexbox untuk mensejajarkan judul dan tombol --}}
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Absensi Ekstrakurikuler') }}
                {{-- Tambahkan nama ekstrakurikuler jika variabel $ekstrakurikuler tersedia dan memiliki properti nama_ekstra --}}
                @if(isset($ekstrakurikuler) && $ekstrakurikuler->nama_ekstra)
                    {{ $ekstrakurikuler->nama_ekstra }}
                @endif
            </h2>

            {{-- Tombol Kembali ke Dashboard PJ --}}
            <a href="{{ route('pj.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-400 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard PJ
            </a>
        </div>
    </x-slot>

    {{-- Sisa kode tampilan Anda --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                        Daftar Absensi
                        {{-- Contoh: untuk Ekstrakurikuler {{ $ekstrakurikuler->nama_ekstra }} --}}
                    </h3>
                    {{-- Tombol Tambah Absensi, dipindahkan ke sini --}}
                    <a href="{{route('pj.cptambahabsensi', ['id' => $ekstrakurikuler->id_ekstrakurikuler])}}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-100 uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-800 dark:active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                        <i class="fas fa-plus me-2"></i> Tambah Absensi
                    </a>
                </div>

                {{-- Tabel Absensi --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700 rounded-md">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tl-lg">
                                    No.
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pertemuan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Keterangan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    File Materi
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tr-lg">
                                    Detail Absensi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                            {{-- Loop melalui data absensi di sini --}}
                            {{-- Contoh data dummy --}}
                            @php
                                $absensi_data = [
                                    ['id' => 1, 'pertemuan' => 1, 'tanggal' => '2025-06-01', 'keterangan' => 'Materi dasar voli', 'file_materi' => 'materi_voli_1.pdf', 'aktif' => true],
                                    ['id' => 2, 'pertemuan' => 2, 'tanggal' => '2025-06-08', 'keterangan' => 'Latihan passing bawah', 'file_materi' => 'passing_voli.doc', 'aktif' => false],
                                    ['id' => 3, 'pertemuan' => 3, 'tanggal' => '2025-06-15', 'keterangan' => 'Strategi pertandingan', 'file_materi' => 'strategi_voli.ppt', 'aktif' => true],
                                ];
                            @endphp

                            @forelse($listAbsensi as $index => $absensi) {{-- Menggunakan $listAbsensi dari controller --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $absensi->pertemuan }} {{-- Asumsi ada kolom 'pertemuan' di model Absensi --}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $absensi->keterangan }} {{-- Asumsi ada kolom 'keterangan' di model Absensi --}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($absensi->file_materi)
                                            <a href="{{ asset('storage/' . $absensi->file_materi) }}" target="_blank" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-500">
                                                Lihat File
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{-- Contoh tombol aktif/non-aktif --}}
                                        @if($absensi->aktif ?? false) {{-- Asumsi ada kolom 'aktif' di model Absensi --}}
                                            <button class="px-3 py-1 bg-green-500 text-white rounded-full text-xs font-semibold hover:bg-green-600 transition">Aktif</button>
                                        @else
                                            <button class="px-3 py-1 bg-red-500 text-white rounded-full text-xs font-semibold hover:bg-red-600 transition">Non Aktif</button>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        {{-- Tombol Lihat Detail Absensi --}}
                                        <a href="{{ route('pj.absensi.detail', $absensi->id) }}" class="inline-flex items-center px-3 py-1 bg-indigo-600 dark:bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-100 uppercase tracking-widest hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:bg-indigo-700 dark:focus:bg-indigo-600 active:bg-indigo-800 dark:active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-300">
                                        Belum ada data absensi untuk ekstrakurikuler ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Akhir Tabel Absensi --}}

            </div>
        </div>
    </div>
</x-app-layout>
