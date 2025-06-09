{{-- resources/views/musahil/list-warga.blade.php --}}

{{-- Langsung gunakan layout khusus musahil. --}}
{{-- Asumsi bahwa route ke halaman ini sudah dilindungi agar hanya musahil yang bisa mengakses. --}}
<x-app-musahil-layout>

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
                                            ID Pendampingan
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID Musahil Pendamping
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            NIM Warga
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Warga
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($list_dampingi as $damping)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $damping->id_pendaping }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $damping->id_musahil_pendamping }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $damping->id_warga }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $damping->nama_warga ?? 'Nama Tidak Ditemukan' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">Lihat Detail</a>
                                                <a href="#" class="text-red-600 hover:text-red-900">Hapus Dampingan</a>
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

</x-app-musahil-layout>