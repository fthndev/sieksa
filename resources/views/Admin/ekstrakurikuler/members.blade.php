<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-base-content leading-tight">
                    Kelola Anggota: {{ $ekskul->nama_ekstra }}
                </h2>
                <p class="text-sm text-base-content/70">Kelola Penanggung Jawab dan daftar peserta ekstrakurikuler.</p>
            </div>
            <a href="{{ route('admin.ekstrakurikuler.index') }}" class="btn btn-sm btn-ghost">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </x-slot>

    {{-- Definisikan state Alpine.js di level atas untuk mengelola satu modal --}}
    <div class="py-12" x-data="{ showModal: false, modalTitle: '', modalMessage: '', modalActionUrl: '', modalMethod: 'POST' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div role="alert" class="alert alert-success shadow-lg"><div><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div></div>
            @endif
            @if(session('error'))
                <div role="alert" class="alert alert-error shadow-lg"><div><i class="fas fa-times-circle"></i><span>{{ session('error') }}</span></div></div>
            @endif

            {{-- Card Penanggung Jawab & Penugasan PJ Baru --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title"><i class="fas fa-user-shield me-2"></i>Penanggung Jawab (PJ)</h2>
                    @if($ekskul->penanggungJawab)
                        <div class="flex items-center justify-between p-4 bg-base-200 rounded-lg mt-2">
                            <p class="font-bold">{{ $ekskul->penanggungJawab->nama }} <span class="font-normal opacity-70">({{ $ekskul->penanggungJawab->nim }})</span></p>
                            {{-- Tombol ini sekarang memicu modal konfirmasi --}}
                            <button @click="showModal = true; modalTitle = 'Konfirmasi Cabut Akses'; modalMessage = 'Anda yakin ingin mencabut status PJ dari pengguna ini?'; modalActionUrl = '{{ route('admin.ekstrakurikuler.members.revoke', $ekskul) }}'; modalMethod = 'POST';" class="btn btn-error">Cabut Akses PJ</button>
                        </div>
                    @else
                        <form action="{{ route('admin.ekstrakurikuler.members.assign', $ekskul) }}" method="POST" class="mt-2">
                            @csrf
                            <label class="label"><span class="label-text">Tugaskan PJ Baru</span></label>
                            <div class="flex items-center gap-2">
                                <select name="nim_pj" class="select select-bordered w-full max-w-xs" required>
                                    <option disabled selected value="">Pilih dari semua pengguna</option>
                                    @foreach($calonPj as $calon)
                                        <option value="{{ $calon->nim }}">{{ $calon->nama }} ({{ $calon->nim }})</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary">Tugaskan</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Card Daftar & Tambah Peserta --}}
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                         <h2 class="card-title"><i class="fas fa-users me-2"></i>Daftar Peserta ({{ $ekskul->pesertas->count() }})</h2>
                        <form action="{{ route('admin.ekstrakurikuler.members.add', $ekskul) }}" method="POST" class="mt-4 sm:mt-0">
                             @csrf
                             <div class="join">
                                 <select name="nim_anggota" class="select select-bordered select join-item" required>
                                     <option disabled selected value="">Pilih Calon Anggota Baru</option>
                                     @foreach($calonAnggota as $calon)
                                         <option value="{{ $calon->nim }}">{{ $calon->nama }} ({{ $calon->nim }})</option>
                                     @endforeach
                                 </select>
                                 <button type="submit" class="btn  btn-primary join-item">Tambahkan</button>
                             </div>
                         </form>
                            <button 
                                @click="
                                    showModal = true;
                                    modalTitle = 'Konfirmasi Keluarkan Semua';
                                    modalMessage = 'Apakah Anda yakin ingin mengeluarkan semua peserta dari ekstrakurikuler ini?';
                                    modalActionUrl = '{{ route('admin.ekstrakurikuler.members.removeAll', $ekskul) }}';
                                    modalMethod = 'DELETE';
                                "
                                class="btn btn-error btn-outline btn-sm ms-2">
                                <i class="fas fa-trash-alt me-1"></i> Keluarkan Semua
                            </button>
                    </div>

                    <div class="overflow-x-auto mt-4">
                        <table class="table w-full">
                            <thead><tr><th>NIM</th><th>Nama</th><th>Role</th><th class="text-center">Aksi</th></tr></thead>
                            <tbody>
                                @forelse($ekskul->pesertas as $peserta)
                                    @if(in_array($peserta->role, ['musahil', 'warga']))
                                        <tr class="hover">
                                            <td>{{ $peserta->nim }}</td>
                                            <td>{{ $peserta->nama }}</td>
                                            <td><span>{{ ($peserta->role) }}</span></td>
                                            <td class="text-center">
                                                {{-- Tombol Keluarkan dengan Modal Konfirmasi --}}
                                                <button @click="showModal = true; modalTitle = 'Konfirmasi Keluarkan Anggota'; modalMessage = 'Keluarkan {{ addslashes($peserta->nama) }}?'; modalActionUrl = '{{ route('admin.ekstrakurikuler.members.remove', ['ekstrakurikuler' => $ekskul -> id_ekstrakurikuler, 'pengguna' => $peserta]) }}'; modalMethod = 'DELETE';" class="btn btn-xs btn-error btn-outline">Keluarkan</button>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                <tr><td colspan="3" class="text-center p-4">Belum ada peserta.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            {{-- Modal Konfirmasi Aksi (Reusable) --}}
            <input type="checkbox" id="confirm-modal" class="modal-toggle" x-model="showModal" />
            <div class="modal modal-bottom sm:modal-middle" role="dialog">
                <div class="modal-box">
                    <h3 class="font-bold text-lg" x-text="modalTitle"></h3>
                    <p class="py-4" x-text="modalMessage"></p>
                    <div class="modal-action">
                        <label for="confirm-modal" class="btn btn-ghost">Batal</label>
                        <form :action="modalActionUrl" method="POST">
                            @csrf
                            {{-- Simulasi metode DELETE/PATCH/PUT untuk form HTML --}}
                            <input type="hidden" name="_method" :value="modalMethod">
                            <button type="submit" class="btn" :class="{'btn-error': modalMethod === 'DELETE', 'btn-primary': modalMethod === 'POST'}">Ya, Lanjutkan</button>
                        </form>
                    </div>
                </div>
                <label class="modal-backdrop" for="confirm-modal">Close</label>
            </div>

        </div>
    </div>

</x-app-layout>