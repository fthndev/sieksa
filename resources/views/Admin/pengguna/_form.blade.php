@csrf
<div class="space-y-6">

    <h2 class="text-2xl font-semibold text-center mb-2">Form Pengguna</h2>

    {{-- NIM --}}
    <div class="form-control">
        <label class="label font-medium text-gray-700">
            <span class="label-text">NIM</span>
        </label>
        <input 
            type="text" 
            name="nim" 
            value="{{ old('nim', $pengguna->nim ?? '') }}" 
            class="input input-bordered w-full @isset($pengguna) bg-base-200 cursor-not-allowed @endisset" 
            @isset($pengguna) disabled @endisset 
            required>
        <x-input-error :messages="$errors->get('nim')" class="mt-2 text-sm text-red-500" />
    </div>

    {{-- Nama Lengkap --}}
    <div class="form-control">
        <label class="label font-medium text-gray-700">
            <span class="label-text">Nama Lengkap</span>
        </label>
        <input 
            type="text" 
            name="nama" 
            value="{{ old('nama', $pengguna->nama ?? '') }}" 
            class="input input-bordered w-full" 
            required>
        <x-input-error :messages="$errors->get('nama')" class="mt-2 text-sm text-red-500" />
    </div>

    {{-- Email --}}
    <div class="form-control">
        <label class="label font-medium text-gray-700">
            <span class="label-text">Email</span>
        </label>
        <input 
            type="email" 
            name="email" 
            value="{{ old('email', $pengguna->email ?? '') }}" 
            class="input input-bordered w-full" 
            required>
        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
    </div>

    {{-- Telepon --}}
    <div class="form-control">
        <label class="label font-medium text-gray-700">
            <span class="label-text">Telepon (Opsional)</span>
        </label>
        <input 
            type="text" 
            name="telepon" 
            value="{{ old('telepon', $pengguna->telepon ?? '') }}" 
            class="input input-bordered w-full">
        <x-input-error :messages="$errors->get('telepon')" class="mt-2 text-sm text-red-500" />
    </div>

    {{-- Role --}}
    <div class="form-control">
        <label class="label font-medium text-gray-700">
            <span class="label-text">Role</span>
        </label>
        <select 
            name="role" 
            class="select select-bordered w-full" 
            required>
            <option disabled {{ old('role', $pengguna->role ?? '') ? '' : 'selected' }}>Pilih Role</option>
            <option value="warga" @selected(old('role', $pengguna->role ?? '') == 'warga')>Warga</option>
            <option value="musahil" @selected(old('role', $pengguna->role ?? '') == 'musahil')>Musahil</option>
            <option value="pj" @selected(old('role', $pengguna->role ?? '') == 'pj')>PJ</option>
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2 text-sm text-red-500" />
    </div>
</div>
