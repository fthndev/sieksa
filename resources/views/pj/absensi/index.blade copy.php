<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            Manajemen Absensi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @forelse ($listEkstrakurikulerDikelola as $ekskul)
                {{-- Setiap card ekstrakurikuler memiliki state Alpine.js-nya sendiri --}}
                <div class="card bg-base-100 shadow-xl" x-data="absensiGenerator()">
                    <div class="card-body">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <h2 class="card-title text-red-600 dark:text-red-400">{{ $ekskul->nama_ekstra }}</h2>
                            <label for="sesi-modal-{{ $ekskul->id_ekstrakurikuler }}" class="btn btn-primary btn-sm mt-2 sm:mt-0">
                                <i class="fas fa-qrcode me-2"></i>Mulai Sesi Baru
                            </label>
                        </div>
                        <hr class="my-4 dark:border-slate-700">
                        
                        {{-- Tabel Histori untuk ekskul ini --}}
                        <h3 class="font-semibold mb-2 text-base-content">Histori Sesi</h3>
                        @if($ekskul->absensi->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="table table-sm w-full">
                                    <thead>
                                        <tr>
                                            <th>Pertemuan</th>
                                            <th>Tanggal</th>
                                            <th>Materi</th>
                                            <th class="text-center">Jumlah Hadir</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ekskul->absensi as $sesi)
                                        <tr class="hover">
                                            <td>{{ $sesi->pertemuan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sesi->tanggal)->translatedFormat('d M Y') }}</td>
                                            <td>{{ Str::limit($sesi->materi, 50) }}</td>
                                            <td class="text-center"><span class="badge badge-ghost">{{ $sesi->jumlah_hadir }}</span></td>
                                            <td class="text-center">
                                                <a href="{{ route('pj.absensi.detail', $sesi) }}" class="btn btn-xs btn-outline btn-info">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-base-content/70">Belum ada sesi absensi untuk ekstrakurikuler ini.</p>
                        @endif
                    </div>

                    {{-- Modal untuk ekskul ini (dibuat unik dengan ID ekskul) --}}
                    <input type="checkbox" id="sesi-modal-{{ $ekskul->id_ekstrakurikuler }}" class="modal-toggle" />
                    <div class="modal modal-bottom sm:modal-middle" role="dialog">
                        <div class="modal-box relative">
                            <label for="sesi-modal-{{ $ekskul->id_ekstrakurikuler }}" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                            <h3 class="font-bold text-lg mb-4">Mulai Sesi untuk: {{ $ekskul->nama_ekstra }}</h3>
                            <div x-show="!qrCodeUrl">
                                <form @submit.prevent="generateQrCode('{{ route('pj.absensi.mulai_sesi_qr', $ekskul) }}', '{{ $ekskul->id_ekstrakurikuler }}')">
                                    <div class="space-y-4">
                                        <div><label class="label"><span class="label-text">Pertemuan Ke</span></label><input type="number" x-model="pertemuan" required placeholder="Cth: 3" class="input input-bordered w-full" /></div>
                                        <div><label class="label"><span class="label-text">Materi Hari Ini</span></label><textarea x-model="materi" rows="3" required placeholder="Cth: Dasar-dasar mikrokontroler" class="textarea textarea-bordered w-full"></textarea></div>
                                        <p x-show="errorMessage" x-text="errorMessage" class="text-sm text-error mt-2" x-cloak></p>
                                    </div>
                                    <div class="modal-action">
                                        <button type="submit" :disabled="isLoading" class="btn btn-primary"><span x-show="isLoading" class="loading loading-spinner"></span><span x-show="!isLoading">Tampilkan QR</span></button>
                                    </div>
                                </form>
                            </div>
                            <div x-show="qrCodeUrl" class="text-center space-y-4" x-cloak>
                                <h4 class="font-semibold">Pindai Kode Ini</h4>
                                <div id="qr-code-container-{{ $ekskul->id_ekstrakurikuler }}" class="flex justify-center p-4 bg-white rounded-md max-w-xs mx-auto"></div>
                                <p class="text-xs text-base-content/70">Kode ini valid selama 10 menit.</p>
                                <div class="modal-action">
                                    <label for="sesi-modal-{{ $ekskul->id_ekstrakurikuler }}" class="btn">Tutup</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body items-center text-center">
                        <p class="text-base-content/70">Anda tidak ditugaskan untuk mengelola ekstrakurikuler manapun.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
    {{-- Script untuk generate QR di sisi klien. Pastikan Anda punya CDN-nya di layout utama --}}
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('absensiGenerator', () => ({
                qrCodeUrl: '',
                pertemuan: '',
                materi: '',
                isLoading: false,
                errorMessage: '',
                generateQrCode(url, ekskulId) {
                    if(!this.pertemuan || !this.materi) {
                        this.errorMessage = 'Pertemuan dan Materi wajib diisi.';
                        return;
                    }
                    this.isLoading = true; this.errorMessage = '';
                    fetch(url, {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'},
                        body: JSON.stringify({ pertemuan: this.pertemuan, materi: this.materi })
                    })
                    .then(response => { if (!response.ok) { return response.json().then(err => { throw err; }); } return response.json(); })
                    .then(data => {
                        if (data.url) {
                            this.qrCodeUrl = data.url;
                            this.$nextTick(() => {
                                const qrContainer = document.getElementById('qr-code-container-' + ekskulId);
                                if (qrContainer) {
                                    qrContainer.innerHTML = '';
                                    const qr = qrcode(0, 'L');
                                    qr.addData(data.url);
                                    qr.make();
                                    qrContainer.innerHTML = qr.createImgTag(6, 4);
                                }
                            });
                        }
                    })
                    .catch(error => {
                        this.errorMessage = error.errors ? Object.values(error.errors).join(' ') : 'Gagal membuat sesi.';
                    })
                    .finally(() => { this.isLoading = false; });
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>