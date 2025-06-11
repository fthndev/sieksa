<x-app-layout>
    {{-- Slot Header untuk judul halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            Absensi QR Code
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body items-center text-center" x-data="qrScanner()">

                    <h2 class="card-title">Scan untuk Mencatat Kehadiran</h2>

                    {{-- Area untuk menampilkan kamera scanner --}}
                    <div class="w-full max-w-sm mx-auto my-4" x-show="scannerStarted">
                        <div id="qr-reader" class="w-full border-4 border-dashed dark:border-slate-600 rounded-lg bg-slate-200 dark:bg-slate-700"></div>
                    </div>

                    {{-- Pesan Hasil Scan --}}
                    <div x-show="scanResult" class="w-full" x-cloak>
                        <div role="alert" class="alert" :class="{ 'alert-success': isSuccess, 'alert-error': !isSuccess }">
                            <i x-show="isSuccess" class="fas fa-check-circle"></i>
                            <i x-show="!isSuccess" class="fas fa-times-circle"></i>
                            <span x-text="scanResult"></span>
                        </div>
                    </div>
                    
                    {{-- Teks Panduan Awal --}}
                    <p class="text-base-content/70" x-show="!scannerStarted && !scanResult">
                        Arahkan kamera ke QR Code yang disediakan oleh Penanggung Jawab untuk mencatat kehadiran Anda.
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
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- Script untuk mengaktifkan dan mengelola QR Code scanner --}}
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
                        console.error("Library Html5Qrcode tidak ditemukan. Pastikan sudah di-import di app.js dan jalankan 'npm run dev'.");
                    }
                },

                startScanner() {
                    this.scannerStarted = true;
                    this.scanResult = '';
                    this.isSuccess = false;

                    this.$nextTick(() => {
                        const onScanSuccess = (decodedText, decodedResult) => {
                            if (this.html5Qrcode && this.html5Qrcode.getState() === 2) { // 2 = Html5QrcodeScannerState.SCANNING
                                this.html5Qrcode.pause();
                            }
                            this.scanResult = 'Memvalidasi & Memproses Absensi...';
                            
                            // Kirim hasil scan (URL) ke server via AJAX
                            fetch(decodedText, {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                this.isSuccess = data.success;
                                this.scanResult = data.message;
                            })
                            .catch(error => {
                                this.isSuccess = false;
                                this.scanResult = 'Terjadi error atau URL tidak valid. Silakan coba lagi.';
                            })
                            .finally(() => {
                                this.stopScanner();
                            });
                        };

                        const onScanFailure = (error) => { /* Abaikan error minor */ };
                        
                        this.html5Qrcode = new window.Html5Qrcode("qr-reader", { verbose: false });
                        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

                        this.html5Qrcode.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure)
                            .catch(err => {
                                this.isSuccess = false;
                                this.scanResult = "Gagal memulai kamera. Pastikan Anda memberikan izin akses kamera pada browser.";
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
</x-app-layout>