<x-app-layout>
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
                <div class="w-20 {{ request()->routeIs('pj.detail_ekstra') ? 'border-b-4 border-b-blue-600 rounded-b-sm' : '' }} flex justify-center p-1">
                    <a href="{{ route('pj.detail_ekstra', ['ekstrakurikuler' => $ekskul->id_ekstrakurikuler]) }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600">Forum</a>
                </div>  
                <div class="w-20 {{ request()->routeIs('pj.daftar_orang_ekstra') ? 'border-b-4 border-b-blue-600 rounded-b-sm' : '' }} flex justify-center p-1">
                    <a href="{{ route('pj.daftar_orang_ekstra', ['ekskul' => $ekskul->id_ekstrakurikuler]) }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600">Orang</a>
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
            {{-- isi halaman --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                    <div class="p-3 ms-4 text-slate-900 dark:text-slate-100 flex gap-3">
                        <div class="flex items-center bg-[#A93425] w-12 h-12 flex justify-center rounded-full">
                            <i class="fa-regular fa-clipboard fa-xl text-white"></i>
                        </div>
                        <div class="flex items-center">
                            <h3 class="text- fosmnt-medium">
                                Ini Merupakan Contoh Materi yang akan diposting!!
                            </h3>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
