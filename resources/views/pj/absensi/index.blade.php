<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            Manajemen Absensi
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="h-[50px] p-4 space-y-4 z-[100]">
            {{-- Notifikasi Sukses --}}
            @if(session('status'))
            <div id="alert-success" role="alert" class="alert alert-success shadow-lg mb-6 opacity-0 transition-opacity duration-500 ease-in-out">
                <div>
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
            @endif
        </div>

            @forelse ($listEkstrakurikulerDikelola as $ekskul)
                {{-- Setiap card ekstrakurikuler memiliki state Alpine.js-nya sendiri --}}
                <div class="card bg-base-100 shadow-xl" x-data="absensiGenerator()">
                    <div class="card-body">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <h2 class="card-title text-red-600 dark:text-red-400">{{ $ekskul->nama_ekstra }}</h2>
                            <button @click="openNewSessionModal('{{ $ekskul->id_ekstrakurikuler }}', '{{ addslashes($ekskul->nama_ekstra) }}')" class="btn btn-primary btn-sm mt-2 sm:mt-0">
                                <i class="fas fa-qrcode me-2"></i>Mulai Sesi Baru
                            </button>
                        </div>
                        <hr class="my-4 dark:border-slate-700">
                        
                        {{-- Tabel Histori untuk ekskul ini --}}
                        <h3 class="font-semibold mb-2 text-base-content">Histori Sesi</h3>
                        @if($ekskul->absensi->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="table table-sm w-full">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Pertemuan</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Materi</th>
                                            <th class="text-center">File Materi</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Jumlah Hadir</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ekskul->absensi as $sesi)
                                        <tr class="hover">
                                            <td>{{ $sesi->pertemuan }}</td>
                                            <td>{{ \Carbon\Carbon::parse($sesi->tanggal)->translatedFormat('d M Y') }}</td>
                                            <td>{{ Str::limit($sesi->materi, 40) }}</td>
                                            <td class="w-1/4">
                                                <form action="{{ route('pj.absensi.upload', $sesi->id_absensi) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="file" name="file_materi" accept=".pdf,.docx" class="file-input file-input-sm file-input-bordered w-full max-w-xs mb-1" required>

                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-upload"></i> Upload
                                                    </button>
                                                    @if($sesi->path)  
                                                        <br>
                                                        <a href="{{ Storage::url($sesi->path) }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                                            <i class="fas fa-download"></i> Download
                                                        </a>
                                                    @endif
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $sesi->status == 'open' ? 'badge-success' : 'badge-error' }}">{{ ucwords($sesi->status) }}</span>
                                            </td>
                                            <td class="text-center"><span class="badge badge-ghost">{{ $sesi->jumlah_hadir }}</span></td>
                                            <td class="text-center whitespace-nowrap">
                                                <a href="{{ route('pj.absensi.detail', $sesi) }}" class="btn btn-xs btn-ghost text-sky-600">Detail</a>
                                                <button @click="showExistingQrCode('{{ route('pj.absensi.regenerate_qr', $sesi) }}', '{{ $ekskul->id_ekstrakurikuler }}', '{{ $sesi->pertemuan }}')" class="btn btn-xs btn-ghost">QR</button>
                                                <form action="{{ route('pj.absensi.toggle_status', $sesi) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-xs btn-outline {{ $sesi->status == 'open' ? 'btn-warning' : 'btn-accent' }}">
                                                        {{ $sesi->status == 'open' ? 'Tutup' : 'Buka' }}
                                                    </button>
                                                </form>
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
                            <label :for="'sesi-modal-' + '{{ $ekskul->id_ekstrakurikuler }}'" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</label>
                            <h3 class="font-bold text-lg mb-4" x-text="modalTitle"></h3>
                            <div x-show="!qrCodeUrl">
                                {{-- Form hanya tampil jika membuat sesi baru --}}
                                <form @submit.prevent="generateQrCode('{{ route('pj.absensi.mulai_sesi_qr', $ekskul) }}', '{{ $ekskul->id_ekstrakurikuler }}')" x-show="isNewSession" class="space-y-4">
                                    {{-- Form input pertemuan dan materi --}}
                                    <div><label class="label"><span class="label-text">Pertemuan Ke</span></label><input type="number" x-model="pertemuan" required class="input input-bordered w-full" /></div>
                                    <div><label class="label"><span class="label-text">Materi Hari Ini</span></label><textarea x-model="materi" rows="3" required class="textarea textarea-bordered w-full"></textarea></div>
                                    <p x-show="errorMessage" x-text="errorMessage" class="text-sm text-error mt-2" x-cloak></p>
                                    <div class="modal-action">
                                        <button type="submit" :disabled="isLoading" class="btn btn-primary"><span x-show="isLoading" class="loading loading-spinner"></span><span x-show="!isLoading">Tampilkan QR</span></button>
                                    </div>
                                </form>
                            </div>
                            <div x-show="qrCodeUrl" class="text-center space-y-4" x-cloak>
                                <h4 class="font-semibold">Pindai Kode Ini</h4>
                                <div id="qr-code-container-{{ $ekskul->id_ekstrakurikuler }}" class="flex justify-center p-4 bg-white rounded-md max-w-xs mx-auto"></div>
                                <p class="text-xs text-base-content/70">Kode ini valid selama 10 menit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Pesan jika tidak ada ekskul yang dikelola --}}
            @endforelse
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/qrcode-generator/qrcode.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('absensiGenerator', () => ({
                    qrCodeUrl: '', pertemuan: '', materi: '', isLoading: false, errorMessage: '', modalTitle: '', ekskulId: null, isNewSession: false,
                    openNewSessionModal(id, nama) {
                        this.reset();
                        this.isNewSession = true;
                        this.ekskulId = id;
                        this.modalTitle = `Mulai Sesi Baru untuk: ${nama}`;
                        document.getElementById(`sesi-modal-${id}`).checked = true;
                    },
                    showExistingQrCode(url, id, pertemuanKe) {
                        this.reset();
                        this.isNewSession = false;
                        this.ekskulId = id;
                        this.modalTitle = `QR Code - Pertemuan Ke-${pertemuanKe}`;
                        document.getElementById(`sesi-modal-${id}`).checked = true;
                        this.isLoading = true;
                        fetch(url, {
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'}
                        })
                        .then(r => r.json()).then(d => { if(d.url) this.renderQrCode(d.url, id); }).catch(e => console.error(e)).finally(() => this.isLoading = false);
                    },
                    generateQrCode(url, id) {
                        if(!this.pertemuan || !this.materi) { this.errorMessage = 'Pertemuan dan Materi wajib diisi.'; return; }
                        this.isLoading = true; this.errorMessage = '';
                        fetch(url, { method: 'POST', headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'}, body: JSON.stringify({ pertemuan: this.pertemuan, materi: this.materi }) })
                        .then(r => { if (!r.ok) { return r.json().then(err => { throw err; }); } return r.json(); })
                        .then(data => { if (data.url) this.renderQrCode(data.url, id); })
                        .catch(e => { this.errorMessage = e.errors ? Object.values(e.errors).join(' ') : 'Gagal membuat sesi.'; })
                        .finally(() => this.isLoading = false);
                    },
                    renderQrCode(url, id) {
                        this.qrCodeUrl = url;
                        this.$nextTick(() => {
                            const qrContainer = document.getElementById('qr-code-container-' + id);
                            if (qrContainer) {
                                qrContainer.innerHTML = ''; const qr = qrcode(0, 'L'); qr.addData(url); qr.make();
                                qrContainer.innerHTML = qr.createImgTag(6, 4);
                            }
                        });
                    },
                    reset() {
                        this.qrCodeUrl = ''; this.pertemuan = ''; this.materi = ''; this.isLoading = false; this.errorMessage = ''; this.isNewSession = false;
                    }
                }));
            });


            document.addEventListener('DOMContentLoaded', function () {
                const alertBox = document.getElementById('alert-success');
                if (alertBox) {
                    setTimeout(() => {
                        alertBox.classList.remove('opacity-0');
                        alertBox.classList.add('opacity-100');
                    }, 100);

                    setTimeout(() => {
                        alertBox.classList.add('opacity-0'); // untuk animasi fade out
                        setTimeout(() => alertBox.remove(), 500); // hapus elemen setelah fade out
                    }, 2000); // tampil selama 3 detik
                }
            });

        </script>
    @endpush
</x-app-layout>