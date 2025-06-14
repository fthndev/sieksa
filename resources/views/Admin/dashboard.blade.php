<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Kartu Statistik Ringkasan --}}
            @if(isset($statistik))
            <div class="stats shadow w-full stats-vertical lg:stats-horizontal">
                {{-- ... Konten statistik Anda tetap sama ... --}}
            </div>
            @endif

            {{-- Panel Manajemen Utama --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title"><i class="fas fa-cogs me-2"></i>Panel Manajemen Utama</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <a href="{{ route('admin.pengguna.index') }}" class="card bg-base-200 hover:bg-base-300 p-6 text-center transition-all group"><div class="text-4xl text-primary group-hover:scale-110 transition-transform"><i class="fas fa-users-cog"></i></div><p class="mt-2 font-semibold">Kelola Pengguna</p></a>
                        <a href="{{ route('admin.ekstrakurikuler.index') }}" class="card bg-base-200 hover:bg-base-300 p-6 text-center transition-all group"><div class="text-4xl text-accent group-hover:scale-110 transition-transform"><i class="fas fa-puzzle-piece"></i></div><p class="mt-2 font-semibold">Kelola Ekstrakurikuler</p></a>
                        <a href="{{route('admin.daftar_absensi_ekstra')}}" class="card bg-base-200 hover:bg-base-300 p-6 text-center transition-all group"><div class="text-4xl text-info group-hover:scale-110 transition-transform"><i class="fas fa-calendar-check"></i></div><p class="mt-2 font-semibold">Kelola Absensi</p></a>
                        <a href="{{route('admin.daftar_materi_ekstra')}}" class="card bg-base-200 hover:bg-base-300 p-6 text-center transition-all group"><div class="text-4xl text-warning group-hover:scale-110 transition-transform"><i class="fas fa-book-open"></i></div><p class="mt-2 font-semibold">Kelola Materi</p></a>
                    </div>
                </div>
            </div>

            {{-- Grafik & Visualisasi dengan Tampilan Diperbaiki --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <div class="card bg-base-100 shadow-xl lg:col-span-2">
                    <div class="card-body">
                        <h2 class="card-title">Distribusi Role Pengguna</h2>
                        <div class="mt-4 flex justify-center items-center h-64">
                             <canvas id="roleDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card bg-base-100 shadow-xl lg:col-span-3">
                    <div class="card-body">
                        <h2 class="card-title">Jumlah Peserta per Ekstrakurikuler</h2>
                         <div class="mt-4 h-64">
                            <canvas id="ekskulPesertaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.Chart === 'undefined') {
                console.error('Chart.js tidak ter-load.');
                return;
            }

            // --- Chart Distribusi Role (tetap sama) ---
            const roleCtx = document.getElementById('roleDistributionChart');
            if(roleCtx) {
                const roleData = {
                    labels: @json($chartRoleData['labels'] ?? []),
                    datasets: [{
                        data: @json($chartRoleData['data'] ?? []),
                        backgroundColor: ['#ef4444', '#3b82f6', '#f59e0b'],
                        hoverOffset: 4
                    }]
                };
                new window.Chart(roleCtx, { type: 'doughnut', data: roleData, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }});
            }

            // --- PERBAIKAN PADA CHART BATANG PESERTA PER EKSKUL ---
            const ekskulCtx = document.getElementById('ekskulPesertaChart');
            if(ekskulCtx) {
                const ekskulData = {
                    labels: @json($chartEkskulData['labels'] ?? []),
                    datasets: [{
                        label: 'Jumlah Peserta',
                        data: @json($chartEkskulData['data'] ?? []),
                        // Atur warna batang, pinggiran, dan radius sudut
                        backgroundColor: 'rgba(225, 29, 72, 0.7)', // Warna tema merah dari DaisyUI: 'primary-content'
                        borderColor: 'rgba(225, 29, 72, 1)',
                        borderWidth: 1,
                        borderRadius: 5,
                        borderSkipped: false,
                    }]
                };
                
                // Cek tema gelap/terang untuk warna teks
                const isDarkMode = document.documentElement.classList.contains('dark');
                const textColor = isDarkMode ? '#a6adbb' : '#374151';

                new window.Chart(ekskulCtx, {
                    type: 'bar',
                    data: ekskulData,
                    options: {
                        indexAxis: 'y', // <-- Kunci untuk membuat grafik menjadi horizontal
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false // Sembunyikan legenda karena hanya ada 1 dataset
                            },
                            tooltip: {
                                backgroundColor: '#1f2937', // Tooltip gelap
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                padding: 10,
                                cornerRadius: 6,
                            }
                        },
                        scales: {
                            x: { // Sumbu X sekarang adalah nilai
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1, // Angka harus bulat
                                    color: textColor
                                },
                                grid: { color: isDarkMode ? '#374151' : '#e5e7eb' }
                            },
                            y: { // Sumbu Y sekarang adalah label
                                ticks: { color: textColor },
                                grid: { display: false } // Sembunyikan grid vertikal agar lebih bersih
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>