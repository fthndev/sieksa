<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-base-content leading-tight">
                Kelola Ekstrakurikuler
            </h2>
            <div x-data="{ showTambah: false }">
                <button @click="showTambah = true" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Baru
                </button>
                <div x-show="showTambah" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
                        <h2 class="text-lg font-semibold mb-4">Tambah Ekstrakurikuler</h2>
                        <form method="POST" action="{{ route('admin.ekstrakurikuler.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="label">Nama Ekstra</label>
                                <input type="text" name="nama_ekstra" class="input input-bordered w-full" required>
                            </div>
                            <div class="mb-3">
                                <label for="label">hari</label>
                                <select name="hari" class="select select-bordered w-full" required>
                                    <option disabled selected value="">Pilih Hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="label">Jam</label>
                                <input type="time" name="jam" class="input input-bordered w-full" required>
                            </div>
                            <div class="mb-3">
                                <label class="label">Kuota</label>
                                <input type="number" name="kuota" class="input input-bordered w-full" required>
                            </div>
                            <div class="mb-3">
                                <label class="label">Keterangan</label>
                                <textarea name="keterangan" class="textarea textarea-bordered w-full"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="label">Penanggung Jawab (NIM)</label>
                                <select name="id_pj" class="select select-bordered w-full" required>
                                    <option disabled selected value="">Pilih Penanggung Jawab</option>
                                    @foreach($calonPj as $calon)
                                        <option value="{{ $calon->nim }}">{{ $calon->nama }} ({{ $calon->nim }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex justify-between mt-6">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" @click="showTambah = false">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div id="success-alert, 'error-alert');" role="alert" class="alert alert-success shadow-lg mb-6">
                    <div><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
                </div>
            @endif
            @if(session('error'))
                <div id="error-alert" role="alert" class="alert alert-error shadow-lg mb-6">
                    <div><i class="fas fa-times-circle"></i><span>{{ session('error') }}</span></div>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($listEkstrakurikuler as $ekskul)
                    <div class="card card-side bg-base-100 shadow-xl transition-all duration-300 hover:shadow-2xl">
                        <figure class="w-1/3 bg-slate-100 dark:bg-slate-800 hidden sm:flex items-center justify-center">
                            <i class="fas fa-shapes text-7xl text-red-500/20"></i>
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">{{ ucwords($ekskul->nama_ekstra) }}</h2>
                            <p class="text-sm text-base-content/70">
                                Jadwal: {{ $ekskul->hari ?: 'N/A' }}
                                @if($ekskul->jam), Pukul {{ \Carbon\Carbon::parse($ekskul->jam)->format('H:i') }} @endif
                            </p>
                            <p class="text-sm text-base-content/70">
                                {{ $ekskul->keterangan ?: 'N/A' }}
                            </p>
                            <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm mt-2">
                                <div class="tooltip" data-tip="Jumlah Peserta Terdaftar">
                                    <span class="badge badge-sm badge-outline"><i class="fas fa-users me-2"></i>{{ $ekskul->pesertas_count }}</span>
                                </div>
                                <div class="tooltip" data-tip="Penanggung Jawab">
                                    <span class="badge badge-sm badge-outline"><i class="fas fa-user-shield me-2"></i>{{ $ekskul->penanggungJawab->nama ?? 'N/A' }}</span>
                                </div>
                                <div class="tooltip" data-tip="Kuota">
                                    <span class="badge badge-sm badge-outline"><i class="fas fa-user-friends me-2"></i>{{ $ekskul->kuota ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="card-actions justify-end mt-4">
                            <div 
                                    x-data="{
                                        editModal: false,
                                        deleteModal: false,
                                        formMode: '',
                                        formData: {
                                            nama_ekstra: '',
                                            hari: '',
                                            jam: '',
                                            kuota: '',
                                            keterangan: ''    
                                            },
                                        submitForm() {
                                            for (const key in this.formData) {
                                                if (this.formData[key] === '') this.formData[key] = null;
                                            }

                                            this.$refs.hidden_nama_ekstra.value = this.formData.nama_ekstra ?? '';
                                            this.$refs.hidden_hari.value = this.formData.hari ?? '';
                                            this.$refs.hidden_jam.value = this.formData.jam ?? '';
                                            this.$refs.hidden_kuota.value = this.formData.kuota ?? '';
                                            this.$refs.hidden_keterangan.value = this.formData.keterangan ?? '';
                                            
                                            this.$refs.editForm.submit();
                                        }
                                    }"
                                >
                                <button 
                                @click="
                                    editModal = true;
                                    formMode = 'edit';
                                    $nextTick(() => {
                                        formData = {
                                            id: {{ $ekskul->id_ekstrakurikuler }},
                                            nama_ekstra: @js($ekskul->nama_ekstra),
                                            hari: @js($ekskul->hari),
                                            jam: @js($ekskul->jam),
                                            kuota: {{ json_encode($ekskul->kuota ?? 0) }},
                                            keterangan: @js($ekskul->keterangan ?? '')
                                        };
                                    });
                                "
                                        class="btn btn-warning"
                                    >
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <button 
                                        @click="deleteModal = true" 
                                        class="btn btn-error" 
                                        title="Hapus Ekstrakurikuler">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- Tombol Kelola Anggota -->
                                    <a href="{{ route('admin.ekstrakurikuler.members', $ekskul) }}" class="btn btn-primary" title="Kelola Anggota">
                                        <i class="fas fa-users-cog me-2"></i> Anggota
                                    </a>

                                    <!-- Modal Hapus -->
                                    <div x-show="deleteModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                                        <div class="bg-white p-6 rounded-xl w-full max-w-md shadow-lg relative">
                                            <button class="absolute top-2 right-2 text-gray-400 hover:text-black" @click="deleteModal = false">&times;</button>
                                            <h2 class="text-xl font-bold mb-4 text-center text-red-600">Konfirmasi Penghapusan</h2>
                                            <p class="text-center mb-6">Apakah Anda yakin ingin menghapus ekstrakurikuler <strong>{{ $ekskul->nama_ekstra }}</strong>?</p>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" class="btn" @click="deleteModal = false">Batal</button>
                                                <form action="{{ route('admin.ekstrakurikuler.destroy', $ekskul->id_ekstrakurikuler) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-error">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Edit -->
                                    <div x-show="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                                        <div class="bg-white p-6 rounded-xl w-full max-w-xl shadow-lg relative">
                                            <form
                                                x-ref="editForm"
                                                @submit.prevent="submitForm"
                                                action="{{ route('admin.ekstrakurikuler.update', $ekskul->id_ekstrakurikuler) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('PUT')

                                                <!-- Hidden inputs untuk value submit -->
                                                <input type="hidden" name="nama_ekstra" x-ref="hidden_nama_ekstra">
                                                <input type="hidden" name="hari" x-ref="hidden_hari">
                                                <input type="hidden" name="jam" x-ref="hidden_jam">
                                                <input type="hidden" name="kuota" x-ref="hidden_kuota">
                                                <input type="hidden" name="keterangan" x-ref="hidden_keterangan">

                                                <!-- Input biasa (terikat ke formData) -->
                                                <div class="mb-3">
                                                    <label>Nama Ekstrakurikuler</label>
                                                    <input type="text" x-model="formData.nama_ekstra" class="input input-bordered w-full">
                                                </div>
                                                <div class="mb-3">
                                                    <select x-model="formData.hari" class="input input-bordered w-full mb-3">
                                                        <option disabled selected>Pilih Hari</option>
                                                        <template x-for="hari in ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']" :key="hari">
                                                            <option :value="hari" x-text="hari"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Jam</label>
                                                    <input type="time" x-model="formData.jam" class="input input-bordered w-full">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Kuota</label>
                                                    <input type="number" x-model="formData.kuota" class="input input-bordered w-full" min="1">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Keterangan</label>
                                                    <textarea x-model="formData.keterangan" class="textarea textarea-bordered w-full"></textarea>
                                                </div>

                                                <div class="mt-4 flex justify-end gap-2">
                                                    <button type="button" class="btn" @click="editModal = false">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card bg-base-100 shadow-xl md:col-span-2">
                        <div class="card-body items-center text-center">
                            <i class="fas fa-info-circle text-4xl text-sky-500 mb-4"></i>
                            <h3 class="card-title">Belum Ada Data</h3>
                            <p>Belum ada data ekstrakurikuler di sistem. Silakan tambahkan yang baru.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $listEkstrakurikuler->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alertBox = document.getElementById('success-alert');
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.transition = 'opacity 0.5s ease';
                    alertBox.style.opacity = '0';
                    setTimeout(() => alertBox.remove(), 500);
                }, 3000);
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            const alertBox = document.getElementById('error-alert');
            if (alertBox) {
                setTimeout(() => {
                    alertBox.style.transition = 'opacity 0.5s ease';
                    alertBox.style.opacity = '0';
                    setTimeout(() => alertBox.remove(), 500);
                }, 3000);
            }
        })
    </script>
</x-app-layout>
