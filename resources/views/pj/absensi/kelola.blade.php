<title>
    Kelola Absensi {{ ucwords($ekstrakurikuler->nama_ekstra) }}
</title>
<x-app-layout>
    {{-- Slot Header --}}
    <x-slot name="header">
        <div class="flex flex-col items-start justify-between gap-2">
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                Manajemen Absensi
            </h2>
            <h4 class="font-semibold text-sm text-slate-600 dark:text-slate-400 leading-tight">
                Ekstrakurikuler: {{ ucwords($ekstrakurikuler->nama_ekstra) }}
            </h4>
        </div>
    </x-slot>

    {{-- Slot Sub-Navigasi Ekstrakurikuler --}}
    <x-slot name="navbar_ekstra">
        {{-- Menggunakan partial sub-navigasi yang sudah kita buat --}}
        @include('layouts.partials.ekstrakurikuler-nav', ['ekskul' => $ekstrakurikuler])
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body" x-data="absensiGenerator()">

                    {{-- Tombol untuk Memulai Sesi --}}
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="card-title">Sesi Absensi Baru</h2>
                            <p class="text-sm text-base-content/70 mt-1">Buat sesi absensi baru dan tampilkan QR Code untuk dipindai oleh peserta.</p>
                        </div>
                        <label for="sesi-modal" class="btn btn-primary">
                            <i class="fas fa-qrcode me-2"></i>Mulai Sesi
                        </label>
                    </div>

                    <hr class="my-4 dark:border-slate-700">

                    {{-- Modal untuk Input dan Tampilan QR Code --}}
                    <input type="checkbox" id="sesi-modal" class="modal-toggle" x-model="openModal" />
                    <div class="modal modal-bottom sm:modal-middle" role="dialog">
                        <div class="modal-box">
                            <h3 class="font-bold text-lg mb-4">Mulai Sesi Absensi Baru</h3>
                            
                            {{-- Form Input --}}
                            <div x-show="!qrCodeUrl">
                                <form @submit.prevent="generateQrCode('{{ route('pj.absensi.mulai_sesi_qr', $ekstrakurikuler) }}')" class="space-y-4">
                                    <div>
                                        <label class="label" for="pertemuan"><span class="label-text">Pertemuan Ke-</span></label>
                                        <input type="number" x-model="pertemuan" id="pertemuan" required placeholder="Contoh: 3" class="input input-bordered w-full" />
                                    </div>
                                    <div>
                                        <label class="label" for="materi"><span class="label-text">Materi Hari Ini</span></label>
                                        <textarea x-model="materi" id="materi" rows="3" required placeholder="Contoh: Dasar-dasar mikrokontroler dan I/O" class="textarea textarea-bordered w-full"></textarea>
                                    </div>
                                    <p x-show="errorMessage" x-text="errorMessage" class="text-sm text-error mt-2"></p>

                                    <div class="modal-action">
                                        <label for="sesi-modal" @click="reset()" class="btn btn-ghost">Batal</label>
                                        <button type="submit" :disabled="isLoading" class="btn btn-primary">
                                            <span x-show="isLoading" class="loading loading-spinner"></span>
                                            <span x-show="!isLoading">Tampilkan QR Code</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            {{-- Tampilan QR Code --}}
                            <div x-show="qrCodeUrl" class="text-center space-y-4">
                                <h4 class="font-semibold">Pindai Kode Ini</h4>
                                <div id="qr-code-container" class="flex justify-center p-4 bg-white rounded-md max-w-xs mx-auto"></div>
                                <p class="text-xs text-base-content/70">Kode ini valid selama 10 menit.</p>
                                <div class="modal-action">
                                    <label for="sesi-modal" @click="reset()" class="btn">Tutup</label>
                                </div>
                            </div>
                        </div>
                        <label class="modal-backdrop" for="sesi-modal">Close</label>
                    </div>

                    {{-- Histori Sesi Absensi --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-200">Histori Sesi</h3>
                        @if($historiSesi && $historiSesi->count() > 0)
                            <div class="overflow-x-auto mt-4">
                                <table class="table w-full">
                                    <thead>
                                        <tr>
                                            <th>Pertemuan</th>
                                            <th>Tanggal</th>
                                            <th>Materi</th>
                                            <th>Jumlah Hadir</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($historiSesi as $sesi)
                                        <tr>
                                            <td class="font-bold">{{ $sesi->pertemuan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sesi->tanggal)->translatedFormat('d F Y') }}</td>
                                            <td>{{ Str::limit($sesi->materi, 50) }}</td>
                                            <td><span class="badge badge-success badge-outline">{{ $sesi->jumlah_hadir }} Orang</span></td>
                                            <td><a href="#" class="btn btn-xs btn-ghost">Lihat Detail</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-base-content/70 mt-2">Belum ada histori sesi absensi untuk ekstrakurikuler ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    {{-- Script untuk generate QR di sisi client. Pastikan Anda punya CDN-nya di layout utama --}}
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('absensiGenerator', () => ({
                openModal: false,
                qrCodeUrl: '',
                pertemuan: '',
                materi: '',
                isLoading: false,
                errorMessage: '',
                reset() {
                    this.openModal = false;
                    this.qrCodeUrl = '';
                    this.pertemuan = '';
                    this.materi = '';
                    this.isLoading = false;
                    this.errorMessage = '';
                },
                generateQrCode(url) {
                    if(!this.pertemuan || !this.materi) {
                        this.errorMessage = 'Pertemuan dan Materi wajib diisi.';
                        return;
                    }
                    this.isLoading = true;
                    this.errorMessage = '';
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ pertemuan: this.pertemuan, materi: this.materi })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => { throw err; });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.url) {
                            this.qrCodeUrl = data.url;
                            this.$nextTick(() => {
                                const qrContainer = document.getElementById('qr-code-container');
                                qrContainer.innerHTML = '';
                                const qr = qrcode(4, 'L');
                                qr.addData(data.url);
                                qr.make();
                                qrContainer.innerHTML = qr.createImgTag(6, 4);
                            });
                        }
                    })
                    .catch(error => {
                        // Menampilkan error validasi dari Laravel
                        if(error.errors) {
                            this.errorMessage = Object.values(error.errors).join(' ');
                        } else {
                            this.errorMessage = 'Gagal membuat sesi. Periksa kembali input Anda.';
                        }
                        console.error('Error:', error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>