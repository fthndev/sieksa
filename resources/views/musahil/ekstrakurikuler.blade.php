<title>
    Materi - Ekstrakurikuler {{ucwords($ekskul->nama_ekstra)}}
</title>
<x-app-musahil-layout>
    <x-slot name="header">
        <div class="flex flex-col items-start justify-between gap-10">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('Ekstrakurikuler ' . ucwords($ekskul->nama_ekstra))}}
            </h2>
            <h4 class="font-semibold text-sm text-slate-800 dark:text-slate-200 leading-tight">
                Asrama Gedung C || <i class="fas fa-calendar-alt me-1 opacity-70"></i> {{ucwords($ekskul->hari);}} || <i class="fas fa-clock me-1 opacity-70"></i> {{ \Carbon\Carbon::createFromFormat('H:i:s', $ekskul->jam)->format('H:i') }}
            </h4>
        </div>
    </x-slot>

    <x-slot name="navbar_ekstra">
            <div class="flex justify-center sm:justify-start space-x-4 pt-1 gap-5">
                <div class="w-20 {{ request()->routeIs('musahil.detail_ekstra') ? 'border-b-4 border-b-blue-600 rounded-b-sm' : '' }} flex justify-center p-1">
                    <a href="{{ route('musahil.detail_ekstra', ['ekstrakurikuler' => $ekskul->id_ekstrakurikuler]) }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600">Forum</a>
                </div>
                <div class="w-20 {{ request()->routeIs('musahil.absensi_ekstra') ? 'border-b-4 border-b-blue-600 rounded-b-sm' : '' }} flex justify-center p-1">
                    @php
                        $user_nim = Auth::user()->nim;
                    @endphp
                    <a href="{{ route('musahil.absensi_ekstra', ['pengguna' => $user_nim]) }}" class="text-sm font-medium {{request()->routeIs('absensi.ekstra') ? 'text-blue-600 font-bold' : 'text-gray-700'}} text-gray-700 dark:text-gray-300 hover:text-blue-600">Absensi</a>
                </div>
                <div class="w-20 {{ request()->routeIs('warga.daftar_orang_ekstra') ? 'border-b-4 border-b-blue-600 rounded-b-sm' : '' }} flex justify-center p-1">
                    <a href="{{ route('musahil.daftar_orang_ekstra', ['ekskul' => $ekskul->id_ekstrakurikuler]) }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600">Orang</a>
                </div>
            </div>
    </x-slot>



    {{-- Konten halaman --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-1">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                Daftar Materi
            </h2>
            <hr class="border-slate-300 dark:border-slate-600" /> 
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
            @foreach($ekskul->absensi as $datamateri)
            @php
                $extension = pathinfo($datamateri->path, PATHINFO_EXTENSION);
            @endphp
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg mb-4">
                <div class="p-3 ms-4 text-slate-900 dark:text-slate-100 flex gap-3">
                    <div class="flex items-center bg-[#A93425] w-12 h-12 flex justify-center rounded-full">
                        <i class="fa-regular fa-clipboard fa-xl text-white"></i>
                    </div>
                    <div class="flex-column">
                        <div class="flex items-center">
                            <h3 class="text-fosmnt-medium">
                                {{ucwords($datamateri->materi)}}
                            </h3>
                        </div>
                        <div>
                            <a href="{{ Storage::url($datamateri->path) }}" target="_blank" class="">
                                @if($extension === "pdf")
                                    <i class="fas fa-file-pdf text-red-500"></i> <span class="text-sm hover:text-blue-600 hover:underline">Lihat File Materi</span>
                                @elseif($extension ==="pptx")
                                    <i class="fas fa-file-word text-blue-500"></i> <span class="hover:text-blue-600 hover:underline text-sm">Lihat File Materi</span> 
                                @elseif($extension === "doc")
                                    <i class="fas fa-file-word text-blue-500"></i> <span class="hover:text-blue-600 hover:underline text-sm">Lihat File Materi</span>
                                @elseif($extension === "docx")
                                    <i class="fas fa-file-powerpoint text-orange-500"></i> <span class="hover:text-blue-600hover:underlinetext-sm">Lihat File Materi</span>
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center ml-auto">
                        <div class="">
                            <span class="italic text-xs font-thin font-[Poppins] text-sm text-gray-500 tracking-wide">
                                Uploaded : {{ date("d F", strtotime($datamateri->tanggal)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-musahil-layout>
