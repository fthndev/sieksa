@csrf
<div class="space-y-4">
    <div class="form-control">
        <label class="label"><span class="label-text">NIM</span></label>
        {{-- NIM hanya bisa diisi saat membuat baru --}}
        <input type="text" name="nim" value="{{ old('nim', $pengguna->nim ?? '') }}" class="input input-bordered @isset($pengguna) bg-base-200 @endisset" @isset($pengguna) disabled @endisset required>
        <x-input-error :messages="$errors->get('nim')" class="mt-2" />
    </div>
    <div class="form-control">
        <label class="label"><span class="label-text">Nama Lengkap</span></label>
        <input type="text" name="nama" value="{{ old('nama', $pengguna->nama ?? '') }}" class="input input-bordered" required>
        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
    </div>
    <div class="form-control">
        <label class="label"><span class="label-text">Email</span></label>
        <input type="email" name="email" value="{{ old('email', $pengguna->email ?? '') }}" class="input input-bordered" required>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    <div class="form-control">
        <label class="label"><span class="label-text">Telepon (Opsional)</span></label>
        <input type="text" name="telepon" value="{{ old('telepon', $pengguna->telepon ?? '') }}" class="input input-bordered">
        <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
    </div>
    <div class="form-control">
        <label class="label"><span class="label-text">Role</span></label>
        <select name="role" class="select select-bordered" required>
            <option disabled selected>Pilih Role</option>
            <option value="warga" @selected(old('role', $pengguna->role ?? '') == 'warga')>Warga</option>
            <option value="musahil" @selected(old('role', $pengguna->role ?? '') == 'musahil')>Musahil</option>
            <option value="pj" @selected(old('role', $pengguna->role ?? '') == 'pj')>PJ</option>
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>
</div>