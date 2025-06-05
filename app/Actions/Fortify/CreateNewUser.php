<?php

namespace App\Actions\Fortify;

use App\Models\Akun;
use App\Models\Pengguna; // Pastikan model Pengguna di-import
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     * @return \App\Models\Pengguna
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(array $input): Pengguna
    {
        // dd('INPUT REGISTRASI:', $input); // 0. Cek input awal jika perlu

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => $this->passwordRules(),
        ])->validate();

        // dd('VALIDASI DASAR LOLOS');

        $pengguna = Pengguna::where('nim', $input['nim'])->first();

        // dd('HASIL PENCARIAN PENGGUNA:', $pengguna ? $pengguna->toArray() : 'TIDAK DITEMUKAN DI TABEL PENGGUNA');

        if (!$pengguna) {
            throw ValidationException::withMessages([
                'nim' => __('NIM Anda belum terdaftar sebagai warga asrama. Silakan hubungi administrator.'),
            ]);
        }

        // dd('NIM DITEMUKAN DI PENGGUNA. CEK EMAIL. DB Email:' . $pengguna->email . ' Input Email:' . $input['email']);

        if (strtolower($pengguna->email) !== strtolower($input['email'])) {
            throw ValidationException::withMessages([
                'email' => __('Email yang Anda masukkan tidak cocok dengan data yang terdaftar untuk NIM ini.'),
            ]);
        }

        // dd('EMAIL COCOK. CEK AKUN EXISTS UNTUK NIM:', $input['nim']);

        $akunExists = Akun::where('nim', $input['nim'])->exists();
        if ($akunExists) {
            throw ValidationException::withMessages([
                'nim' => __('Akun untuk NIM ini sudah terdaftar. Silakan login atau gunakan fitur lupa password.'),
            ]);
        }

        // dd('AKUN BELUM ADA. AKAN MEMBUAT AKUN UNTUK NIM:', $pengguna->nim);

        // Pastikan model Akun Anda memiliki $casts = ['password' => 'hashed'];
        // Jika tidak, gunakan Hash::make($input['password']) untuk 'password' di bawah ini.
        $createdAkun = Akun::create([
            'nim' => $pengguna->nim,
            'password' => $input['password'],
        ]);

        dd('AKUN BERHASIL DIBUAT:', $createdAkun->toArray());

        // ---- DEBUG KRUSIAL SEBELUM RETURN ----
        if (!($pengguna instanceof \App\Models\Pengguna)) {
            // Ini seharusnya tidak terjadi jika $pengguna diambil dengan Pengguna::where()
            dd('ERROR FATAL: Variabel $pengguna BUKAN instance dari App\Models\Pengguna sebelum return!', get_class($pengguna), $pengguna);
        }
        if ($pengguna instanceof \App\Models\Akun) {
            dd('ERROR FATAL: Variabel $pengguna TERNYATA adalah instance Akun sebelum return!', $pengguna);
        }
        // Hentikan di sini untuk melihat apa yang akan di-return
        dd('CreateNewUser AKAN ME-RETURN objek Pengguna:', $pengguna->toArray(), 'Class:', get_class($pengguna));
        // ---- AKHIR DEBUG KRUSIAL ----

        return $pengguna;
    }
}