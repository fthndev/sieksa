<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-base-content leading-tight">Edit Pengguna: {{ $pengguna->nama }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <form action="{{ route('admin.pengguna.update', $pengguna) }}" method="POST">
                        @method('PATCH')
                        @include('admin.pengguna._form', ['pengguna' => $pengguna])
                        <div class="card-actions justify-end mt-6">
                            <a href="{{ route('admin.pengguna.index') }}" class="btn btn-ghost">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>