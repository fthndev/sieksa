{{-- resources/views/pj/dashboard.blade.php --}}
<title>
    Dashboard - PJ
</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Dashboard Penanggung Jawab (PJ)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Kartu Selamat Datang --}}
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-slate-900 dark:text-slate-100">
                    <h3 class="text-lg font-medium">
                        Selamat datang di Panel Penanggung Jawab, {{ $user->nama ?? 'PJ' }}!
                    </h3>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                        Anda dapat mengelola ekstrakurikuler, melihat laporan, dan mengatur aspek lain dari sistem di sini.
                    </p>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-700 dark:text-red-400 mb-4 flex items-center">
                        <i class="fas fa-rocket me-3 opacity-80"></i>
                        Aksi Cepat Lainnya
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                         <a href="{{route('pj.absensi.index')}}" class="flex flex-col items-center justify-center p-4 bg-slate-50 dark:bg-slate-700/50 hover:bg-red-50 dark:hover:bg-red-700/20 rounded-lg transition-colors duration-150 group border border-slate-200 dark:border-slate-700">
                            <i class="fas fa-calendar-check fa-2x mb-2 text-red-600 dark:text-red-500 group-hover:text-red-700 dark:group-hover:text-red-400"></i>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-red-700 dark:group-hover:text-red-400 text-center">Kelola Absensi Warga</span>
                        </a>
                        {{-- Tombol aksi lainnya --}}
                    </div>
                </div>
            </div>

            {{-- Kartu Statistik Ringkasan --}}
            @if(isset($statistik))
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-slate-800 p-6 shadow-md rounded-lg flex items-center">
                        <div class="p-3 rounded-full bg-red-100 dark:bg-red-700/30 mr-4 shrink-0">
                            <i class="fas fa-shapes fa-lg text-red-600 dark:text-red-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Ekstrakurikuler Dikelola</p>
                            <p class="text-2xl font-semibold text-slate-700 dark:text-slate-200">{{ $statistik['totalEkstrakurikuler'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-800 p-6 shadow-md rounded-lg flex items-center">
                        <div class="p-3 rounded-full bg-sky-100 dark:bg-sky-700/30 mr-4 shrink-0">
                            <i class="fas fa-users fa-lg text-sky-600 dark:text-sky-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Total Warga Terdaftar</p>
                            <p class="text-2xl font-semibold text-slate-700 dark:text-slate-200">{{ $statistik['totalWarga'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-800 p-6 shadow-md rounded-lg flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100 dark:bg-emerald-700/30 mr-4 shrink-0">
                            <i class="fas fa-user-shield fa-lg text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Total Musahil Terdaftar</p>
                            <p class="text-2xl font-semibold text-slate-700 dark:text-slate-200">{{ $statistik['totalMusahil'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Daftar Ekstrakurikuler yang Dikelola --}}
            @if(session('success'))
                <div id="success-alert" role="alert" class="alert alert-success shadow-lg mb-6">
                    <div><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
                </div>
            @endif
            @if(session('error'))
                <div id="error-alert" role="alert" class="alert alert-error shadow-lg mb-6">
                    <div><i class="fas fa-times-circle"></i><span>{{ session('error') }}</span></div>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                        <h3 class="text-lg font-semibold text-red-700 dark:text-red-400 flex items-center mb-2 sm:mb-0">
                            <i class="fas fa-cogs me-3 opacity-80"></i>
                            Ekstrakurikuler yang Anda Kelola
                        </h3>
                        {{-- Tombol ke halaman absensi
                        @if($listEkstrakurikulerDikelola && $listEkstrakurikulerDikelola->isNotEmpty())
                            <a href="{{ route('pj.absensi', ['id' => $listEkstrakurikulerDikelola->first()->id_ekstrakurikuler]) }}"
                               class="inline-flex items-center px-4 py-2 bg-red-600 dark:bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-100 uppercase tracking-widest hover:bg-red-700 dark:hover:bg-red-600 focus:bg-red-700 dark:focus:bg-red-600 active:bg-red-800 dark:active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                                <i class="fas fa-list-check me-2"></i> Lihat Absensi
                            </a>
                        @endif --}}
                    </div>
                    @if ($listEkstrakurikulerDikelola && $listEkstrakurikulerDikelola->count() > 0)
                        <div class="space-y-6">
                            @foreach ($listEkstrakurikulerDikelola as $ekskul)
                                @php
                                    $kuota = $ekskul->kuota ?? 0;
                                    $jumlahPeserta = $ekskul && $ekskul->pesertas ? $ekskul->pesertas->count() : 0;
                                    $kuota_ekstra_now = $kuota - $jumlahPeserta;
                                @endphp
                                <h4 class="text-md font-semibold text-slate-800 dark:text-slate-100">{{ ucwords($ekskul->nama_ekstra) }}</h4> 
                                    {{-- Jadwal Display --}}
                                    <p class="text-xs text-slate-500 dark:text-slate-400" id="jadwal-display-{{ $ekskul->id_ekstrakurikuler }}">
                                        Jadwal: {{ $ekskul->hari ?: '-' }} - {{ $ekskul->jam ? \Carbon\Carbon::parse($ekskul->jam)->format('H:i') : '-' }} | Kuota: {{ $ekskul->kuota ?? 'N/A' }} 
                                    </p>
                                    <span class="text-green-600 dark:text-green-400 text-xs dark:text-slate-400">Tersisa: {{ $kuota_ekstra_now }}</span>

                                    {{-- Jadwal Form (hidden by default) --}}
                                    <form id="jadwal-form-{{ $ekskul->id_ekstrakurikuler }}" action="{{ route('pj.dashboards', ['id' => $ekskul->id_ekstrakurikuler]) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex gap-2 items-center">
                                            <select name="hari" class="select select-bordered">
                                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu','Libur'] as $hari)
                                                    <option value="{{ $hari }}" {{ $ekskul->hari == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                                                @endforeach
                                            </select>
                                            <input type="time" name="jam" value="{{ $ekskul->jam }}" class="input inputinput-bordered">
                                        </div>
                                    </form>
                                </div>
                                {{-- Tombol Aksi --}}
                                <div class="mt-2 sm:mt-0">
                                    <a href="#"
                                    class="text-xs text-sky-600 dark:text-sky-400 hover:underline me-2"
                                    onclick="toggleEdit({{ $ekskul->id_ekstrakurikuler }})"
                                    id="btn-edit-{{ $ekskul->id_ekstrakurikuler }}">Edit jadwal</a>

                                    <a id="btn-detail-{{ $ekskul->id_ekstrakurikuler }}"
                                    href="{{ route('pj.lihatpeserta', ['id' => $ekskul->id_ekstrakurikuler]) }}"
                                    data-href-lihatpeserta="{{ route('pj.lihatpeserta', ['id' => $ekskul->id_ekstrakurikuler]) }}"
                                    class="text-xs text-sky-600 dark:text-sky-400 hover:underline me-2">
                                    Lihat Detail Peserta
                                    </a>    
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center text-slate-600 dark:text-slate-400">
                            <i class="fas fa-info-circle me-3 text-lg"></i>
                            <p>Anda saat ini tidak mengelola ekstrakurikuler manapun.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            ['success-alert', 'error-alert'].forEach(id => {
                const alertBox = document.getElementById(id);
                if (alertBox) {
                    setTimeout(() => {
                        alertBox.style.transition = 'opacity 0.5s ease';
                        alertBox.style.opacity = '0';
                        setTimeout(() => alertBox.remove(), 500);
                    }, 3000);
                }
            });
        });
        function toggleEdit(id) {
            const display = document.getElementById(`jadwal-display-${id}`);
            const form = document.getElementById(`jadwal-form-${id}`);
            const btnEdit = document.getElementById(`btn-edit-${id}`);
            const btnDetail = document.getElementById(`btn-detail-${id}`);

            // Cek apakah sedang mode edit
            if (form.classList.contains('hidden')) {
                display.classList.add('hidden');
                form.classList.remove('hidden');

                btnEdit.textContent = 'Simpan';
                btnEdit.setAttribute('onclick', `document.getElementById('jadwal-form-${id}').submit()`);

                btnDetail.textContent = 'Cancel';
                btnDetail.setAttribute('href', '#');
                btnDetail.setAttribute('onclick', `cancelEdit(${id})`);
            }
        }

        function cancelEdit(id) {
            const display = document.getElementById(`jadwal-display-${id}`);
            const form = document.getElementById(`jadwal-form-${id}`);
            const btnEdit = document.getElementById(`btn-edit-${id}`);
            const btnDetail = document.getElementById(`btn-detail-${id}`);

            form.classList.add('hidden');
            display.classList.remove('hidden');

            btnEdit.textContent = 'Edit jadwal';
            btnEdit.setAttribute('onclick', `toggleEdit(${id})`);

            btnDetail.textContent = 'Lihat Detail Peserta';
            btnDetail.setAttribute('href', `/pj/dashboard`);
            btnDetail.removeAttribute('onclick'); // pastikan onclick dihapus agar tidak bertabrakan
        }
    </script>
</x-app-layout>
