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
                                <label class="label">Hari</label>
                                <input type="text" name="hari" class="input input-bordered w-full" required>
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
                <div id="success-alert" role="alert" class="alert alert-success shadow-lg mb-6">
                    <div><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
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
                            <div class="flex flex-wrap gap-x-4 gap-y-2 text-sm mt-2">
                                <div class="tooltip" data-tip="Jumlah Peserta Terdaftar">
                                    <span class="badge badge-lg badge-outline"><i class="fas fa-users me-2"></i>{{ $ekskul->pesertas_count }}</span>
                                </div>
                                <div class="tooltip" data-tip="Penanggung Jawab">
                                    <span class="badge badge-lg badge-outline"><i class="fas fa-user-shield me-2"></i>{{ $ekskul->penanggungJawab->nama ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="card-actions justify-end mt-4">
                            <div x-data="{ editModal: false, formData: {}, formMode: '' }">
                                <button 
                                @click="
                                    editModal = true;
                                    formMode = 'edit';
                                    formData = {
                                        id: {{ $ekskul->id_ekstrakurikuler }},
                                        nama_ekstra: @js($ekskul->nama_ekstra),
                                        hari: @js($ekskul->hari),
                                        jam: @js($ekskul->jam),
                                        kuota: {{ $ekskul->kuota ?? 0 }},
                                        keterangan: @js($ekskul->keterangan ?? ''),
                                        id_pj: @js($ekskul->id_pj ?? '')
                                    }
                                "
                                    class="btn btn-warning" >
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <div x-show="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
                                    <div class="bg-white p-6 rounded-xl w-full max-w-xl shadow-lg relative">
                                        <button class="absolute top-2 right-2 text-gray-400 hover:text-black" @click="editModal = false">&times;</button>
                                        <h2 class="text-xl font-bold mb-4" x-text="formMode === 'edit' ? 'Edit Ekstrakurikuler' : 'Tambah Ekstrakurikuler'"></h2>
                                        <form action="{{route('admin.ekstrakurikuler.update', $ekskul->id_ekstrakurikuler)}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="_method" value="PUT">
                                            <template x-if="formMode === 'edit'">
                                                <input type="hidden" name="_method" value="PUT">
                                            </template>

                                            <div class="mb-3">
                                                <label>Nama Ekstrakurikuler</label>
                                                <input type="text" name="nama_ekstra" x-model="formData.nama_ekstra" class="input input-bordered w-full" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Hari</label>
                                                <input type="text" name="hari" x-model="formData.hari" class="input input-bordered w-full" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Jam</label>
                                                <input type="time" name="jam" x-model="formData.jam" class="input input-bordered w-full" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Kuota</label>
                                                <input type="number" name="kuota" x-model="formData.kuota" class="input input-bordered w-full" min="1" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Keterangan</label>
                                                <textarea name="keterangan" x-model="formData.keterangan" class="textarea textarea-bordered w-full"></textarea>
                                            </div>
                                            <div class="mt-4 flex justify-end gap-2">
                                                <button type="button" class="btn" @click="editModal = false">Batal</button>
                                                <button type="submit" class="btn btn-primary" x-text="formMode === 'edit' ? 'Update' : 'Simpan'"></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                                <a href="{{ route('admin.ekstrakurikuler.members', $ekskul) }}" class="btn btn-primary">
                                    Kelola Anggota <i class="fas fa-arrow-right ms-2"></i>
                                </a>
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
    </script>
</x-app-layout>
