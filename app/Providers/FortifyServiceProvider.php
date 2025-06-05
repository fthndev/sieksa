<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Actions\Fortify\CreateNewUser; // Pastikan action ini ada dan disesuaikan

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Daftarkan custom response untuk redirect setelah login/register jika perlu
        // $this->app->singleton(\Laravel\Fortify\Contracts\LoginResponse::class, \App\Http\Responses\LoginResponse::class);
        // $this->app->singleton(\Laravel\Fortify\Contracts\RegisterResponse::class, \App\Http\Responses\RegisterResponse::class);
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class); // Untuk registrasi

        Fortify::authenticateUsing(function (Request $request) {
            // Validasi input 'nim' dan 'password'
            $credentials = $request->validate([
                'nim' => ['required', 'string'], // Field input di form login Anda
                'password' => ['required', 'string'],
            ]);

            $akun = Akun::where('nim', $credentials['nim'])->first();

            if ($akun && Hash::check($credentials['password'], $akun->password)) {
                // Jika valid, kembalikan instance Pengguna yang berelasi
                return $akun->pengguna; // Ini akan membuat Auth::user() menjadi Pengguna
            }

            // Jika login gagal
            throw ValidationException::withMessages([
                'nim' => [trans('auth.failed')], // Kaitkan error dengan field 'nim'
            ]);
        });

        // Konfigurasi views jika Anda tidak menggunakan default Fortify (opsional jika Blade Breeze sudah ada)
        // Fortify::loginView(fn () => view('auth.login'));
        // Fortify::registerView(fn () => view('auth.register'));
        // Fortify::verifyEmailView(fn () => view('auth.verify-email')); // Jika Anda pakai verifikasi email
    }
}