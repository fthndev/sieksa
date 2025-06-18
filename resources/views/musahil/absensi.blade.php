<title>
    Absensi - Musahil
</title>
<x-app-musahil-layout>
    {{-- Slot Header --}}
    <x-slot name="header">
        @if($ekskul)
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                Absensi Ekstrakurikuler: {{ ucwords($ekskul->nama_ekstra) }}
            </h2>
        @else
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                Absensi
            </h2>
        @endif
    </x-slot>

    {{-- Slot navbar_ekstra sudah dihapus sepenuhnya --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Konten hanya akan tampil jika warga terdaftar di ekstrakurikuler utama --}}
            @if($ekskul)
                
                {{-- 1. Bagian untuk Scan QR --}}
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center" x-data="qrScanner()">
                        <h2 class="card-title">Scan untuk Mencatat Kehadiran</h2>
                        
                        {{-- Pesan Hasil Scan --}}
                        <div x-show="scanResult" class="w-full mt-4" x-cloak>
                            <div role="alert" class="alert" :class="{ 'alert-success': isSuccess, 'alert-error': !isSuccess }">
                                <i x-show="isSuccess" class="fas fa-check-circle"></i>
                                <i x-show="!isSuccess" class="fas fa-times-circle"></i>
                                <span x-text="scanResult"></span>
                            </div>
                        </div>
                        
                        {{-- Panduan Awal --}}
                        <p class="text-base-content/70" x-show="!scannerStarted && !scanResult">
                            Arahkan kamera ke QR Code yang disediakan oleh Penanggung Jawab.
                        </p>

                        {{-- Tombol Aksi --}}
                        <div class="card-actions justify-center mt-4">
                            <button @click="startScanner" class="btn btn-primary" x-show="!scannerStarted">
                                <i class="fas fa-camera me-2"></i>Mulai Scan
                            </button>
                            <button @click="stopScanner" class="btn btn-ghost" x-show="scannerStarted">
                                <i class="fas fa-stop-circle me-2"></i>Batalkan Scan
                            </button>
                        </div>

                        {{-- Area Kamera Scanner --}}
                        <div class="w-full max-w-sm mx-auto rounded-lg overflow-hidden mt-4" x-show="scannerStarted">
                            <div id="qr-reader" class="w-full border-4 border-dashed dark:border-slate-600 rounded-lg bg-slate-200 dark:bg-slate-700"></div>
                        </div>
                    </div>
                </div>

                {{-- 2. Bagian untuk Histori Absensi Pribadi --}}
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title"><i class="fas fa-history me-2"></i>Histori Absensi Anda</h2>
                        @if($historiAbsensiPribadi->isNotEmpty())
                            <div class="overflow-x-auto mt-4">
                                <table class="table w-full">
                                    <thead>
                                        <tr>
                                            <th>Pertemuan</th>
                                            <th>Tanggal</th>
                                            <th>Materi</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($historiAbsensiPribadi as $detail)
                                        <tr class="hover">
                                            <td class="font-semibold">{{ $detail->absensi->pertemuan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($detail->absensi->tanggal)->translatedFormat('d F Y') }}</td>
                                            <td>{{ Str::limit($detail->absensi->materi, 40) }}</td>
                                            <td class="text-center">
                                                @php
                                                    $status = strtolower($detail->status);
                                                    $badgeClass = match ($status) {
                                                        'hadir' => 'badge-success',
                                                        'izin', 'sakit' => 'badge-info',
                                                        'absen', 'alpha' => 'badge-error',
                                                        default => 'badge-ghost',
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }} font-semibold">{{ ucwords($detail->status) }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-base-content/70">Anda belum memiliki histori absensi untuk ekstrakurikuler ini.</p>
                            </div>
                        @endif
                    </div>
                </div>

            @else
                {{-- Tampilan jika warga belum terdaftar di ekskul utama --}}
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center">
                        <i class="fas fa-info-circle text-4xl text-sky-500 mb-4"></i>
                        <h3 class="card-title">Anda Belum Terdaftar</h3>
                        <p class="text-base-content/70">Anda harus terdaftar di ekstrakurikuler utama untuk dapat melakukan absensi.</p>
                        <div class="card-actions justify-center mt-4">
                            <a href="{{ route('warga.dashboard') }}" class="btn btn-primary btn-sm">Kembali ke Dashboard</a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Script untuk QR Scanner (perlu di-push ke stack 'scripts' di app.blade.php) --}}
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('qrScanner', () => ({
                scannerStarted: false,
                scanResult: '',
                isSuccess: false,
                html5Qrcode: null,
                init() {
                    if (typeof window.Html5Qrcode === 'undefined') {
                        this.scanResult = 'Error: Library scanner tidak ter-load.';
                        console.error("Library Html5Qrcode tidak ditemukan.");
                    }
                },
                startScanner() {
                    this.scannerStarted = true;
                    this.scanResult = '';
                    this.isSuccess = false;
                    this.$nextTick(() => {
                        const onScanSuccess = (decodedText, decodedResult) => {
                            if (this.html5Qrcode && this.html5Qrcode.getState() === 2) { this.html5Qrcode.pause(); }
                            this.scanResult = 'Memproses absensi...';
                            fetch(decodedText, {
                                method: 'GET',
                                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', }
                            })
                            .then(response => response.json())
                            .then(data => {
                                this.isSuccess = data.success;
                                this.scanResult = data.message;
                            })
                            .catch(error => {
                                this.isSuccess = false;
                                this.scanResult = 'Terjadi error atau URL tidak valid.';
                            })
                            .finally(() => { this.stopScanner(); });
                        };
                        const onScanFailure = (error) => {};
                        this.html5Qrcode = new window.Html5Qrcode("qr-reader", { verbose: false });
                        this.html5Qrcode.start({ facingMode: "environment" }, { fps: 10, qrbox: { width: 250, height: 250 } }, onScanSuccess, onScanFailure)
                            .catch(err => {
                                this.isSuccess = false;
                                this.scanResult = "Gagal memulai kamera. Pastikan Anda memberikan izin akses kamera.";
                                this.scannerStarted = false;
                            });
                    });
                },
                stopScanner() {
                    if (this.html5Qrcode && this.html5Qrcode.isScanning) {
                        this.html5Qrcode.stop().catch(err => console.error("Gagal menghentikan scanner.", err));
                    }
                    this.scannerStarted = false;
                }
            }));
        });
    </script>
    @endpush
</x-app-musahil-layout>