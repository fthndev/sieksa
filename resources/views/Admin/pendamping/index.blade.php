<x-app-layout>
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">Kelola Pendamping</h2>

        <table class="table w-full table-zebra">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Musahhil</th>
                    <th>Ekstrakurikuler</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($musahhilList as $musahhil)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $musahhil->nama }}</td>
                        <td>{{ $musahhil->ekstrakurikuler->nama_ekstra ?? '-' }}</td>
                        <td class="flex gap-2">
                            <a href="{{ route('admin.pendamping.warga', $musahhil->nim) }}" class="btn btn-sm btn-primary">
                                Lihat Warga
                            </a>

                            <!-- Button to open modal -->
                            <button onclick="openModal('{{ $musahhil->nim }}')" class="btn btn-sm btn-success">
                                Tambah Warga
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">Tambah Warga ke Pendamping</h3>
                <form method="POST" action="{{ route('admin.pendamping.tambah') }}">
                    @csrf
                    <input type="hidden" name="nim_musahhil" id="nim_musahhil_modal">
                    <label for="nim_warga" class="block mb-1">Pilih Warga</label>
                    <select name="nim_warga" id="nim_warga" class="select select-bordered w-full mb-4" required>
                        <option value="" disabled selected>-- Pilih Warga --</option>
                        @foreach($wargaTanpaPendamping as $warga)
                            <option value="{{ $warga->nim }}">{{ $warga->nama }} ({{ $warga->nim }})</option>
                        @endforeach
                    </select>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeModal()" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(nimMusahhil) {
            document.getElementById('nim_musahhil_modal').value = nimMusahhil;
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.getElementById('modal').classList.remove('flex');
        }
    </script>
</x-app-layout>
