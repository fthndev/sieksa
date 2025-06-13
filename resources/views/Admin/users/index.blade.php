<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">
            Kelola Akun Pengguna
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    {{-- Form untuk Search dan Filter --}}
                    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-6" x-data="{ searchFocus: false }">
                        <div class="flex flex-col md:flex-row gap-4">
                            {{-- Filter by Role --}}
                            <select name="role" class="select select-bordered" onchange="this.form.submit()">
                                <option value="">Semua Role</option>
                                <option value="pj" @selected(request('role') == 'pj')>PJ</option>
                                <option value="musahil" @selected(request('role') == 'musahil')>Musahil</option>
                                <option value="warga" @selected(request('role') == 'warga')>Warga</option>
                            </select>

                            {{-- Search Input dengan Animasi --}}
                            <div class="relative w-full md:w-1/3">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="fas fa-search text-base-content/50"></i>
                                </span>
                                <input type="text" name="search" placeholder="Cari nama atau NIM..."
                                       @focus="searchFocus = true" @blur="searchFocus = false"
                                       class="input input-bordered w-full pl-10 transition-all duration-300"
                                       :class="searchFocus ? 'w-full' : 'w-full'"
                                       value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>

                    {{-- Tabel Pengguna --}}
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                <tr class="hover">
                                    <td>
                                        <div class="font-bold">{{ $user->nama }}</div>
                                        <div class="text-sm opacity-70">{{ $user->email }}</div>
                                    </td>
                                    <td>{{ $user->nim }}</td>
                                    <td><span class="badge badge-ghost">{{ ucwords($user->role) }}</span></td>
                                    <td class="text-center">
                                        @if (Auth::id() !== $user->nim) {{-- Ganti Auth::id() dengan Auth::user()->nim --}}
                                        <button onclick="confirmDelete('{{ route('admin.users.destroy', $user) }}', '{{ $user->nama }}')" class="btn btn-xs btn-error btn-outline">
                                            Hapus
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center p-4">Tidak ada data yang ditemukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Navigasi Paginasi --}}
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- Import SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Script untuk notifikasi setelah redirect
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            @endif
        });

        // Script untuk modal konfirmasi hapus
        function confirmDelete(url, name) {
            Swal.fire({
                title: 'Anda Yakin?',
                text: `Akun untuk "${name}" akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form dinamis dan submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;

                    form.appendChild(methodInput);
                    form.appendChild(csrfInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }
    </script>
    @endpush
</x-app-layout>