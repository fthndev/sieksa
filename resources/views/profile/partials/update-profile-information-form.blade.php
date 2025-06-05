<section>
    <header>
        <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    {{-- Form untuk mengirim ulang email verifikasi (jika diperlukan) --}}
    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    @endif

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Name Input with Floating Label & Icon --}}
        <div class="relative group">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none z-20">
                <i class="fas fa-user text-slate-400 group-focus-within:text-red-600 dark:text-slate-500 dark:group-focus-within:text-red-500 transition-colors duration-300"></i>
            </div>
            <input
                id="name"
                name="name" {{-- Name atribut tetap 'name' untuk ProfileUpdateRequest bawaan --}}
                type="text"
                class="block ps-10 pe-3.5 py-3.5 w-full text-sm text-slate-900 dark:text-white bg-transparent rounded-lg border-2 border-slate-300 dark:border-slate-600 appearance-none focus:outline-none focus:ring-0 focus:border-red-600 dark:focus:border-red-500 peer"
                value="{{ old('name', $user->nama) }}" {{-- Menggunakan $user->nama --}}
                required
                autofocus
                autocomplete="name"
                placeholder=" "
            />
            <label
                for="name"
                class="absolute text-sm text-slate-500 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-red-600 dark:peer-focus:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[38px] peer-placeholder-shown:start-[38px] peer-focus:start-3"
            >
                {{ __('Nama Lengkap') }}
            </label>
            <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('name')" />
        </div>

        {{-- Email Address Input with Floating Label & Icon --}}
        <div class="relative group">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none z-20">
                <i class="fas fa-envelope text-slate-400 group-focus-within:text-red-600 dark:text-slate-500 dark:group-focus-within:text-red-500 transition-colors duration-300"></i>
            </div>
            <input
                id="email"
                name="email"
                type="email"
                class="block ps-10 pe-3.5 py-3.5 w-full text-sm text-slate-900 dark:text-white bg-transparent rounded-lg border-2 border-slate-300 dark:border-slate-600 appearance-none focus:outline-none focus:ring-0 focus:border-red-600 dark:focus:border-red-500 peer"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username" {{-- Sesuai standar Breeze, bisa juga 'email' --}}
                placeholder=" "
            />
            <label
                for="email"
                class="absolute text-sm text-slate-500 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-red-600 dark:peer-focus:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[38px] peer-placeholder-shown:start-[38px] peer-focus:start-3"
            >
                {{ __('Alamat Email') }}
            </label>
            <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-slate-700 dark:text-slate-300">
                        {{ __('Alamat email Anda belum terverifikasi.') }}
                        <button form="send-verification" class="underline text-sm text-red-600 dark:text-red-500 hover:text-red-700 dark:hover:text-red-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-slate-800">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Contoh Tambahan: Telepon Input with Floating Label & Icon (Opsional) --}}
        {{-- Pastikan 'telepon' ada di $fillable model Pengguna dan divalidasi di ProfileUpdateRequest --}}
        <div class="relative group">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none z-20">
                <i class="fas fa-phone text-slate-400 group-focus-within:text-red-600 dark:text-slate-500 dark:group-focus-within:text-red-500 transition-colors duration-300"></i>
            </div>
            <input
                id="telepon"
                name="telepon" {{-- Sesuaikan name jika ProfileUpdateRequest mengharapkannya --}}
                type="text"
                class="block ps-10 pe-3.5 py-3.5 w-full text-sm text-slate-900 dark:text-white bg-transparent rounded-lg border-2 border-slate-300 dark:border-slate-600 appearance-none focus:outline-none focus:ring-0 focus:border-red-600 dark:focus:border-red-500 peer"
                value="{{ old('telepon', $user->telepon) }}" {{-- Menggunakan $user->telepon --}}
                autocomplete="tel"
                placeholder=" "
            />
            <label
                for="telepon"
                class="absolute text-sm text-slate-500 dark:text-slate-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-slate-800 px-2 peer-focus:px-2 peer-focus:text-red-600 dark:peer-focus:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[38px] peer-placeholder-shown:start-[38px] peer-focus:start-3"
            >
                {{ __('Nomor Telepon (Opsional)') }}
            </label>
            <x-input-error class="mt-1.5 text-xs" :messages="$errors->get('telepon')" />
        </div>


        <div class="flex items-center gap-4 pt-2">
            {{-- Mengganti x-primary-button dengan button biasa agar bisa di-style penuh --}}
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-700 dark:bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-100 uppercase tracking-widest hover:bg-red-800 dark:hover:bg-red-700 focus:bg-red-800 dark:focus:bg-red-700 active:bg-red-900 dark:active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-green-600 dark:text-green-400"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>