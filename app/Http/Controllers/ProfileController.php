<?php

namespace App\Http\Controllers; // Pastikan namespace ini benar

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
// Model Pengguna akan otomatis di-resolve oleh type-hinting atau dari Auth::user()
// use App\Models\Pengguna;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        /** @var \App\Models\Pengguna $user */
        // Dengan setup Fortify yang mengembalikan Pengguna, $request->user() sudah merupakan instance Pengguna
        $user = $request->user();

        // Tidak perlu lagi:
        // $akun = $request->user();
        // $pengguna = $akun->pengguna;

        // Pengecekan jika $user tidak ada (seharusnya dihandle middleware auth)
        if (!$user) {
            abort(401, 'Pengguna tidak terautentikasi.');
        }

        return view('profile.edit', [
            'user' => $user, // Langsung kirim instance Pengguna ke view
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var \App\Models\Pengguna $user */
        $user = $request->user(); // $user sudah merupakan instance Pengguna

        // Validated data akan berisi 'name' dan 'email' (dari ProfileUpdateRequest)
        // Langsung fill ke model Pengguna
        $user->nama = $request->input('name');
        $user->email = $request->input('email');
        $user->telepon = $request->input('telepon');

        $user->save(); // Simpan perubahan pada model Pengguna

        return Redirect::route('profile.edit')->with('success', 'Profile Anda telah Berhasil Dirubah!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'], // 'current_password' akan cek password di tabel 'akun' via model Pengguna
        ]);

        /** @var \App\Models\Pengguna $user */
        $user = $request->user(); // $user adalah instance Pengguna

        Auth::logout();

        // Menghapus $user (Pengguna) akan men-trigger penghapusan 'akun' yang berelasi
        // JIKA Anda sudah setup ON DELETE CASCADE pada foreign key di tabel 'akun'
        // atau jika Anda menghapus $user->akun secara manual sebelum menghapus $user.
        // Disarankan untuk memastikan ON DELETE CASCADE di level database untuk 'akun.nim' -> 'pengguna.nim'.
        
        // Jika relasi akun() didefinisikan di Pengguna, Anda mungkin perlu menghapus akun terkait dulu
        // atau pastikan database constraint yang menangani cascade.
        // Untuk lebih aman jika tidak yakin dengan cascade:
        if ($user->akun) { // Cek jika relasi akun ada
            $user->akun->delete(); // Hapus record Akun terkait
        }
        $user->delete(); // Kemudian hapus record Pengguna


        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function update_pw(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'], // 'current_password' akan cek password di tabel 'akun' via model Pengguna
        ]);

        /** @var \App\Models\Pengguna $user */
        $user = $request->user();
        $akun = \App\Models\Akun::where('nim', $user->nim)->first();
        $nim_akun = $akun->nim;
        return Redirect::to('/');
    }
}
