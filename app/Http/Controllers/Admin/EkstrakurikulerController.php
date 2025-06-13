<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; // <-- PENTING: Tambahkan ini
use Illuminate\Support\Facades\DB;     // <-- PENTING: Tambahkan ini

class EkstrakurikulerController extends Controller
{
    /**
     * Menampilkan halaman daftar semua ekstrakurikuler untuk dikelola Admin.
     */
    public function index(): View
    {
        $listEkstrakurikuler = Ekstrakurikuler::with('penanggungJawab')
                                             ->withCount('pesertas')
                                             ->orderBy('nama_ekstra', 'asc')
                                             ->paginate(10);

        return view('admin.ekstrakurikuler.index', [
            'user' => Auth::user(),
            'listEkstrakurikuler' => $listEkstrakurikuler
        ]);
    }

    /**
     * Menampilkan halaman untuk mengelola anggota sebuah ekstrakurikuler.
     */
    public function showMembers(Ekstrakurikuler $ekstrakurikuler): View
    {
        $calonAnggota = Pengguna::where('role', '!=', 'admin')
                                ->whereNull('id_ekstrakurikuler')
                                ->orderBy('nama')->get();

        $calonPj = Pengguna::whereIn('role', ['warga', 'musahil'])
                           ->orderBy('nama')->get();

        $ekstrakurikuler->load(['penanggungJawab', 'pesertas' => function ($query) {
            $query->orderBy('nama', 'asc');
        }]);

        return view('admin.ekstrakurikuler.members', [
            'ekskul' => $ekstrakurikuler,
            'calonAnggota' => $calonAnggota,
            'calonPj' => $calonPj,
        ]);
    }
    
    /**
     * Menambahkan anggota baru ke ekstrakurikuler.
     */
    public function addMember(Request $request, Ekstrakurikuler $ekstrakurikuler): RedirectResponse
    {
        $validated = $request->validate(['nim_anggota' => 'required|exists:pengguna,nim']);
        $pengguna = Pengguna::find($validated['nim_anggota']);

        if ($pengguna->id_ekstrakurikuler) {
            return back()->with('error', "Gagal, {$pengguna->nama} sudah terdaftar di ekskul lain.");
        }

        $pengguna->id_ekstrakurikuler = $ekstrakurikuler->id_ekstrakurikuler;
        $pengguna->save();

        return back()->with('success', "{$pengguna->nama} berhasil ditambahkan ke ekstrakurikuler.");
    }

    /**
     * Mengeluarkan seorang anggota dari ekstrakurikuler utama.
     */
    public function removeMember(Request $request, Ekstrakurikuler $ekstrakurikuler, Pengguna $pengguna): RedirectResponse
    {
        if ($ekstrakurikuler->id_pj === $pengguna->nim) {
            return back()->with('error', "Gagal: {$pengguna->nama} adalah Penanggung Jawab. Cabut status PJ terlebih dahulu.");
        }

        if ($pengguna->id_ekstrakurikuler != $ekstrakurikuler->id_ekstrakurikuler) {
            return back()->with('error', 'Pengguna bukan anggota dari ekstrakurikuler ini.');
        }

        $pengguna->id_ekstrakurikuler = null;
        $pengguna->save();

        return back()->with('success', "Anggota '{$pengguna->nama}' berhasil dikeluarkan dari ekstrakurikuler.");
    }

    /**
     * Menugaskan seorang anggota menjadi PJ untuk ekstrakurikuler ini.
     */
    public function assignPj(Request $request, Ekstrakurikuler $ekstrakurikuler): RedirectResponse
    {
        $validated = $request->validate(['nim_pj' => ['required', 'exists:pengguna,nim']]);
        $calonPj = Pengguna::find($validated['nim_pj']);

        // Pastikan calon PJ adalah anggota ekskul ini
        if ($calonPj->id_ekstrakurikuler != $ekstrakurikuler->id_ekstrakurikuler) {
            return back()->with('error', 'Hanya anggota dari ekstrakurikuler ini yang bisa dijadikan PJ.');
        }

        DB::transaction(function () use ($ekstrakurikuler, $calonPj) {
            if ($pjLama = $ekstrakurikuler->penanggungJawab) {
                $pjLama->role = 'warga';
                $pjLama->save();
            }
            $calonPj->role = 'pj';
            $calonPj->save();
            $ekstrakurikuler->update(['id_pj' => $calonPj->nim]);
        });
        return back()->with('success', "{$calonPj->nama} berhasil ditugaskan sebagai PJ baru.");
    }

    /**
     * Mencabut status PJ dari ekstrakurikuler ini.
     */
    public function revokePj(Request $request, Ekstrakurikuler $ekstrakurikuler): RedirectResponse
    {
        if ($pjLama = $ekstrakurikuler->penanggungJawab) {
            DB::transaction(function () use ($ekstrakurikuler, $pjLama) {
                $ekstrakurikuler->id_pj = null;
                $ekstrakurikuler->save();
                $pjLama->role = 'warga';
                $pjLama->save();
            });
            return back()->with('success', "Status PJ untuk {$pjLama->nama} berhasil dicabut.");
        }
        return back()->with('error', 'Ekstrakurikuler ini tidak memiliki Penanggung Jawab.');
    }
}