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
        $query = Pengguna::with('akun')->where('role', '!=', 'admin');

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
        // Otorisasi: Pastikan admin tidak bisa menghapus dirinya sendiri
        if (auth()->user()->nim == $pengguna->nim) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus akun terkait (jika ada) dan data pengguna akan ikut terhapus
        // karena ON DELETE CASCADE di database
        optional($pengguna->akun)->delete();
        $pengguna->delete();


        return back()->with('success', "Akun untuk {$pengguna->nama} berhasil dihapus.");
    }
}