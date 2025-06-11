{{-- resources/views/partials/qr-scanner.blade.php --}}
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

        {{-- Tombol Mulai Scan --}}
        <div class="card-actions justify-center mt-4" x-show="!scannerStarted">
            <button @click="startScanner" class="btn btn-primary">
                <i class="fas fa-camera me-2"></i>Mulai Scan
            </button>
        </div>

        {{-- Area untuk menampilkan kamera scanner --}}
        <div class="w-full max-w-sm mx-auto rounded-lg overflow-hidden" x-show="scannerStarted">
            <div id="qr-reader" class="w-full border-2 border-dashed dark:border-slate-600 rounded-lg p-1 bg-slate-200"></div>
            <button @click="stopScanner" class="btn btn-sm btn-ghost mt-2">Batalkan Scan</button>
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
                    console.error("Library Html5Qrcode tidak ditemukan. Pastikan sudah di-import di app.js dan jalankan 'npm run dev'.");
                }
            },

            startScanner() {
                this.scannerStarted = true;
                this.scanResult = '';
                this.isSuccess = false;

                this.$nextTick(() => {
                    const onScanSuccess = (decodedText, decodedResult) => {
                        if (this.html5Qrcode && this.html5Qrcode.isScanning) {
                            this.html5Qrcode.pause();
                        }
                        this.scanResult = 'Memproses absensi...';

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
                            this.scanResult = 'Terjadi error atau URL tidak valid.';
                            console.error('Error:', error);
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