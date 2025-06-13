<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PenggunaController extends Controller
{
    /**
     * Menampilkan halaman daftar semua pengguna dengan filter dan search.
     */
    public function index(Request $request): View
    {
        // Query ini sudah benar, mengambil pengguna non-admin beserta relasinya
        $query = Pengguna::with(['akun', 'ekstrakurikuler'])->where('role', '!=', 'admin');

        // Logika Pencarian
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('nim', 'like', "%{$request->search}%");
            });
        }

        // Logika Filter Berdasarkan Role
        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('nama')->paginate(10)->withQueryString();

        // Mengirim data ke view dengan nama variabel 'users'
        return view('admin.pengguna.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function create(): View
    {
        return view('admin.pengguna.create');
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:pengguna,nim',
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna,email',
            'telepon' => 'nullable|string|max:20',
            'role' => 'required|in:warga,musahil,pj',
        ]);

        Pengguna::create($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     */
    public function edit(Pengguna $pengguna): View
    {
        // Route Model Binding otomatis memberikan objek $pengguna.
        // Kita kirim ke view dengan nama variabel 'user' agar cocok dengan view Anda.
        return view('admin.pengguna.edit', ['pengguna' => $pengguna]);
    }

    /**
     * Mengupdate data pengguna di database.
     */
    public function update(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pengguna,email,' . $pengguna->nim . ',nim',
            'telepon' => 'nullable|string|max:20',
            'role' => 'required|in:warga,musahil,pj',
        ]);

        $pengguna->update($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dan akun terkait secara permanen.
     */
    public function destroy(Pengguna $pengguna): RedirectResponse
    {
        if (auth()->user()->nim == $pengguna->nim) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus akun terkait (jika ada).
        // Jika Anda set ON DELETE CASCADE di database, ini tidak perlu,
        // tapi ini cara yang aman jika Anda lupa set constraint.
        optional($pengguna->akun)->delete();
        // Hapus pengguna
        $pengguna->delete();

        return back()->with('success', "Pengguna {$pengguna->nama} berhasil dihapus permanen.");
    }

    /**
     * Menangani permintaan impor data pengguna.
     * (Logika ini tetap di sini jika Anda ingin menggunakannya nanti)
     */
    // public function import(Request $request): RedirectResponse
    // { ... }
}