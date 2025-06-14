<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Menampilkan halaman daftar semua pengguna dengan filter dan search.
     */
    public function index(Request $request): View
    {
        $query = Pengguna::whereHas('akun')->where('role', '!=', 'admin');

        // Logika Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        // Logika Filter Berdasarkan Role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        return view('admin.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Menghapus akun dan data pengguna.
     */
    public function destroy(Pengguna $pengguna): RedirectResponse
    {
        // Otorisasi: Pastikan admin tidak bisa menghapus akunnya sendiri
        if (auth()->user()->nim == $pengguna->nim) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // --- PERBAIKAN LOGIKA SESUAI PERMINTAAN ANDA ---

        // 1. Cari akun yang berelasi dengan pengguna ini melalui relasi 'akun'
        $akun = $pengguna->akun;

        // 2. Jika akunnya ada, hapus.
        if ($akun) {
            $akun->delete(); // Ini hanya akan menghapus record dari tabel 'akun'

            return back()->with('success', "Akun untuk pengguna '{$pengguna->nama}' berhasil dihapus. Pengguna ini sekarang tidak bisa login.");
        } else {
            // 3. Jika akunnya memang tidak ada, beri pesan informasi.
            return back()->with('info', "Pengguna '{$pengguna->nama}' memang belum memiliki akun untuk dihapus.");
        }
    }
}