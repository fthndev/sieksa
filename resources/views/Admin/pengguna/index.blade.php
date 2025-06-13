<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-base-content leading-tight">Kelola Pengguna</h2>
            <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>Tambah Pengguna</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.pengguna.index') }}" class="mb-6"><div class="flex flex-col md:flex-row gap-2"><select name="role" class="select select-bordered" onchange="this.form.submit()"><option value="">Semua Role</option><option value="pj" @selected(request('role') == 'pj')>PJ</option><option value="musahil" @selected(request('role') == 'musahil')>Musahil</option><option value="warga" @selected(request('role') == 'warga')>Warga</option></select><input type="text" name="search" placeholder="Cari nama atau NIM..." class="input input-bordered w-full" value="{{ request('search') }}"><button type="submit" class="btn btn-primary">Cari</button></div></form>
                    <div class="overflow-x-auto"><table class="table w-full"><thead><tr><th>Nama</th><th>Role</th><th>Ekskul Utama</th><th>Status Akun</th><th class="text-center">Aksi</th></tr></thead><tbody>@forelse ($users as $user)<tr class="hover"><td><div class="font-bold">{{ $user->nama }}</div><div class="text-sm opacity-70">{{ $user->email }}</div></td><td><span class="badge badge-ghost">{{ ucwords($user->role) }}</span></td><td>{{ optional($user->ekstrakurikuler)->nama_ekstra ?? 'N/A' }}</td><td>@if($user->akun)<span class="badge badge-success">Aktif</span>@else<span class="badge badge-warning">Belum Dibuat</span>@endif</td><td class="text-center space-x-1"><a href="{{ route('admin.pengguna.edit', $user) }}" class="btn btn-xs btn-outline btn-info">Edit</a><button onclick="confirmDelete('{{ route('admin.pengguna.destroy', $user) }}', '{{ addslashes($user->nama) }}')" class="btn btn-xs btn-outline btn-error">Hapus</button></td></tr>@empty<tr><td colspan="5" class="text-center p-4">Tidak ada data.</td></tr>@endforelse</tbody></table></div>
                    <div class="mt-6">{{ $users->links() }}</div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success')) Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: "{{ session('success') }}", showConfirmButton: false, timer: 3000 }); @endif
        function confirmDelete(url, name) {
            Swal.fire({
                title: 'Anda Yakin?', text: `Akun untuk "${name}" akan dihapus permanen!`, icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST'; form.action = url;
                    const csrf = document.createElement('input'); csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
                    const method = document.createElement('input'); method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE';
                    form.appendChild(csrf); form.appendChild(method);
                    document.body.appendChild(form); form.submit();
                }
            })
        }
    </script>
    @endpush
</x-app-layout>