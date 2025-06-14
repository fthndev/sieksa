<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <h2 class="font-semibold text-xl text-base-content leading-tight text-center md:text-left">
                Daftar Materi Ekstrakurikuler
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">                
           <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex flex-col md:flex-row gap-2 mb-4 justify-end">
                        <form action="{{route('admin.clear_materi')}}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua data absensi?')" class="inline-block">
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
                                    <th>Nomor</th>
                                    <th>Nama Ekstrakurikuler</th>
                                    <th>Materi</th>
                                    <th>Tanggal Uploaded</th>
                                    <th>File Uploaded</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $num = 1
                                @endphp
                                @forelse ($data_materi as $materi)
                                    @if($materi->path !== NULL)
                                        <tr>
                                            <td>
                                                {{$num}}
                                            </td>
                                            <td>{{ucwords($materi->ekstrakurikuler->nama_ekstra)}}</td>
                                            <td>{{ucwords($materi->materi)}}</td>
                                            <td>{{ucwords($materi->tanggal)}}</td>
                                            <td>{{ucwords($materi->path)}}</td>
                                            <td class="space-x-2 text-center">
                                                <form action="{{route('admin.hapus_materi', $materi->id_absensi)}}" method="POST" class="inline-block"
                                                    onsubmit="return confirm('Yakin ingin menghapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-white-600 text-orange-600 text-sm font-semibold rounded hover:bg-orange-100 transition duration-200">
                                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @php
                                            $num += 1
                                        @endphp
                                    @endif
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