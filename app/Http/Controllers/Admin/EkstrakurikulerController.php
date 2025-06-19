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

    public function index(): View
    {
        $listEkstrakurikuler = Ekstrakurikuler::with(['penanggungJawab', 'pesertas'])
                                             ->withCount('pesertas')
                                             ->orderBy('nama_ekstra', 'asc')
                                             ->paginate(10);
    
        // Ambil calon PJ (misalnya hanya yang belum punya ekstrakurikuler & rolenya warga atau musahil)
        $calonPj = Pengguna::whereNull('id_ekstrakurikuler')
                           ->whereIn('role', [ 'musahil'])
                           ->get();

        $statusAktif = Ekstrakurikuler::first()?->status ?? 'tutup';
        $data = Ekstrakurikuler::all();
    
        return view('admin.ekstrakurikuler.index', [
            'user' => Auth::user(),
            'listEkstrakurikuler' => $listEkstrakurikuler,
            'calonPj' => $calonPj, // ⬅️ kirim ke view
            'statusAktif' => $statusAktif,
            'data' => $data
        ]);
    }
    
    

    /**
     * Menampilkan halaman untuk mengelola anggota sebuah ekstrakurikuler.
     */
    public function showMembers(Ekstrakurikuler $ekstrakurikuler): View
    {
        $calonAnggota = Pengguna::where('role', '!=', ['admin', 'pj'])
                                ->whereNull('id_ekstrakurikuler')
                                ->orderBy('nama')->get();

        $calonPj = Pengguna::whereIn('role', ['musahil'])
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
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_ekstra'   => 'required|string|max:255',
            'hari'          => 'required|string',
            'jam'           => 'required',
            'kuota'         => 'required|integer|min:1',
            'keterangan'    => 'nullable|string',
            'id_pj'         => 'required|exists:pengguna,nim',
        ]);
    
        try {
            DB::transaction(function () use ($validated) {
                // Buat data ekstrakurikuler baru
                $ekskul = Ekstrakurikuler::create([
                    'nama_ekstra'   => $validated['nama_ekstra'],
                    'hari'          => $validated['hari'],
                    'jam'           => $validated['jam'],
                    'kuota'         => $validated['kuota'],
                    'keterangan'    => $validated['keterangan'] ?? null,
                    'id_pj'         => $validated['id_pj'],
                ]);
    
                // Update pengguna menjadi PJ
                $pj = Pengguna::where('nim', $validated['id_pj'])->first();
                $pj->update([
                    'role' => 'pj',
                    'id_ekstrakurikuler' => $ekskul->id_ekstrakurikuler,
                ]);
            });
    
            return back()->with('success', 'Ekstrakurikuler berhasil ditambahkan dan PJ diperbarui.');
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), 'Jadwal ini bentrok dengan ekstra lainnya')) {
                return back()->with('error', 'Gagal: Jadwal ini bentrok dengan ekstrakurikuler lainnya.');
            }
    
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function toggleStatus()
    {
    $ekstrakurikulerAktif = Ekstrakurikuler::where('status', 'buka')->exists();

    if ($ekstrakurikulerAktif) {
        Ekstrakurikuler::where('status', 'buka')->update(['status' => 'tutup']);
        return redirect()->back()->with('tutup', 'Seluruh ekstrakurikuler berhasil ditutup.');
    } else {
        Ekstrakurikuler::where('status', 'tutup')->update(['status' => 'buka']);
        return redirect()->back()->with('status', 'Seluruh ekstrakurikuler berhasil dibuka.');
    }
    }   



    public function destroy($id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
    
        DB::transaction(function () use ($ekskul) {
            // Ambil pengguna yang jadi PJ
            $pj = Pengguna::where('nim', $ekskul->id_pj)->first();
    
            if ($pj) {
                $pj->update([
                    'role' => 'musahil',
                    'id_ekstrakurikuler' => null,
                ]);
            }
    
            // Hapus data ekstrakurikuler
            $ekskul->delete();
        });
    
        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Data berhasil dihapus');
    }
    
    public function update(Request $request, Ekstrakurikuler $ekskul): RedirectResponse
    {
        try {
            // Ambil semua input
            $input = $request->all();
    
            // Ganti string kosong jadi null
            foreach ($input as $key => $value) {
                if ($value === '') {
                    $input[$key] = null;
                }
            }
    
            // Gunakan nilai lama jika null
            $data = [
                'nama_ekstra' => $input['nama_ekstra'] ?? $ekskul->nama_ekstra,
                'hari'        => $input['hari'] ?? $ekskul->hari,
                'jam'         => $input['jam'] ?? $ekskul->jam,
                'kuota'       => $input['kuota'] ?? $ekskul->kuota,
                'keterangan'  => $input['keterangan'] ?? $ekskul->keterangan,
            ];
    
            // Validasi
            $validated = validator($data, [
                'nama_ekstra' => 'required|string|max:255',
                'hari'        => 'required|string',
                'kuota'       => 'required|integer|min:1',
                'jam'         => 'required',
                'keterangan'  => 'nullable|string',
            ])->validate();
    
            // Simpan perubahan
            $ekskul->update($validated);
    
            return back()->with('success', 'Ekstrakurikuler berhasil diupdate.');
    
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangkap error trigger (jadwal bentrok)
            if (str_contains($e->getMessage(), 'Jadwal ini bentrok dengan ekstra lainnya')) {
                return redirect()->back()->with('error', 'Gagal: Jadwal ini bentrok dengan ekstrakurikuler lainnya.');
            }
    
            // Tangkap error lain (debugging opsional)
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
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
    public function removeAllMembers(Ekstrakurikuler $ekskul): RedirectResponse
    {
        Pengguna::where('id_ekstrakurikuler', $ekskul->id_ekstrakurikuler)
            ->whereIn('role', ['warga', 'musahil']) // ✅ hanya role tertentu
            ->update(['id_ekstrakurikuler' => null]);
    
        return back()->with('success', 'Semua peserta (warga & musahil) berhasil dikeluarkan dari ekstrakurikuler.');
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
                $pjLama->role = 'musahil';
                $pjLama->save();
            });
            return back()->with('success', "Status PJ untuk {$pjLama->nama} berhasil dicabut.");
        }
        return back()->with('error', 'Ekstrakurikuler ini tidak memiliki Penanggung Jawab.');
    }
    public function addMember(Request $request, Ekstrakurikuler $ekstrakurikuler): RedirectResponse
    {
        $validated = $request->validate([
            'nim_anggota' => 'required|exists:pengguna,nim',
        ]);

        DB::transaction(function () use ($validated, $ekstrakurikuler) {
            $pengguna = Pengguna::where('nim', $validated['nim_anggota'])->lockForUpdate()->firstOrFail();

            if ($pengguna->id_ekstrakurikuler) {
                throw new \Exception("Sudah terdaftar di ekskul lain.");
            }

            $pengguna->update([
                'id_ekstrakurikuler' => $ekstrakurikuler->id_ekstrakurikuler
            ]);
        });

        return back()->with('success', "Berhasil menambahkan anggota.");
    }
}