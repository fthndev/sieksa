<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use App\Models\Pengguna; // <-- Import model Pengguna
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException; // <-- Import untuk error kustom
use Illuminate\View\View;
// use App\Providers\RouteServiceProvider; // Untuk redirect default jika perlu

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Pastikan view 'auth.register' memiliki field untuk name, nim, email, password, dan password_confirmation
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input Dasar dari Form Registrasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'], // Asumsi form mengirim 'name'
            'nim' => ['required', 'string', 'max:20'],   // Validasi dasar untuk NIM
            'email' => ['required', 'string', 'email', 'lowercase', 'max:255'], // Email, lowercase
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // Password dengan konfirmasi
        ]);

        // 2. Cek #1: Apakah NIM ada di tabel 'pengguna'?
        $pengguna = Pengguna::where('nim', $request->nim)->first();

        if (!$pengguna) {
            // Jika NIM tidak ditemukan di tabel pengguna
            throw ValidationException::withMessages([
                'nim' => __('NIM Anda belum terdaftar sebagai warga asrama. Silakan hubungi administrator.'),
            ]);
        }

        // 3. Cek #2: Kesesuaian data Email (dan opsional Nama) dengan data di 'pengguna'
        // Perbandingan dibuat case-insensitive untuk email
        if (strtolower($pengguna->email) !== strtolower($request->email)) {
            throw ValidationException::withMessages([
                'email' => __('Email yang Anda masukkan tidak cocok dengan data yang terdaftar untuk NIM ini.'),
            ]);
        }
        // Opsional: Validasi kesesuaian nama jika diperlukan
        // if (strtolower($pengguna->nama) !== strtolower($request->name)) {
        //     throw ValidationException::withMessages([
        //         'name' => __('Nama yang Anda masukkan tidak cocok dengan data yang terdaftar untuk NIM ini.'),
        //     ]);
        // }

        // 4. Cek #3: Apakah NIM sudah memiliki akun di tabel 'akun'?
        $akunExists = Akun::where('nim', $request->nim)->exists();
        if ($akunExists) {
            throw ValidationException::withMessages([
                'nim' => __('Akun untuk NIM ini sudah terdaftar. Silakan login atau gunakan fitur lupa password.'),
            ]);
        }

        // 5. Jika semua validasi lolos, buat entri baru di tabel 'akun'
        // Password akan otomatis di-hash jika model Akun memiliki $casts = ['password' => 'hashed']
        // Jika tidak, gunakan Hash::make($request->password)
        $akun = Akun::create([
            'nim' => $pengguna->nim, // Gunakan NIM dari objek $pengguna yang sudah valid
            'password' => $request->password, // Akan di-hash oleh model Akun jika $casts ada
        ]);

        // 6. Login pengguna (menggunakan instance Pengguna)
        // Ini penting karena config/auth.php kita mengharapkan Pengguna sebagai model Authenticatable
        Auth::login($pengguna);

        // 7. Trigger event Registered (menggunakan instance Pengguna)
        event(new Registered($pengguna)); // Kirim instance Pengguna

        // 8. Redirect berdasarkan Role Pengguna
        $user = Auth::user(); // $user sekarang adalah instance Pengguna
        $redirectPath = route('dashboard', [], false); // Default redirect jika role tidak spesifik

        if ($user && isset($user->role)) {
            switch (trim(strtolower($user->role))) {
                case 'warga':
                    $redirectPath = route('warga.dashboard', [], false);
                    break;
                case 'musahil':
                    $redirectPath = route('musahil.dashboard', [], false);
                    break;
                case 'pj':
                    $redirectPath = route('pj.dashboard', [], false);
                    break;
            }
        }
        // Menggunakan redirect ke path yang sudah ditentukan, bukan intended karena ini registrasi baru
        return redirect($redirectPath);
    }
}