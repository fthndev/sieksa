<x-app-layout>
    <div class="container">
        <h2 class="text-2xl font-bold mb-4">
            Daftar Warga Didampingi oleh {{ $musahhil->nama }}
        </h2>

        <a href="{{ route('admin.pendamping.index') }}" class="btn btn-sm btn-secondary mb-4">
            ← Kembali ke Kelola Pendamping
        </a>

        @if($wargaList->isEmpty())
            <p>Tidak ada warga yang didampingi.</p>
        @else
        <table class="table w-full table-zebra">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Warga</th>
                    <th>NIM</th>
                    <th>Ekstrakurikuler</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wargaList as $index => $warga)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $warga->nama }}</td>
                    <td>{{ $warga->nim }}</td>
                    <td>{{ $warga->ekstrakurikuler->nama_ekstra ?? '-' }}</td>
                    <td>
                        <button onclick="openConfirmModal('{{ route('admin.pendamping.destroy', $warga->nim) }}')" class="btn btn-sm btn-error">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-lg font-bold mb-4 text-center">Konfirmasi Hapus</h3>
            <p class="mb-4 text-center">Apakah Anda yakin ingin menghapus pendampingan untuk warga ini?</p>
            <form id="confirmDeleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeConfirmModal()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-error">Hapus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openConfirmModal(actionUrl) {
            const modal = document.getElementById('confirmModal');
            const form = document.getElementById('confirmDeleteForm');
            form.action = actionUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeConfirmModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
