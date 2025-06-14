<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\DetailAbsensi;
use App\Models\Ekstrakurikuler;
use App\Models\Pengguna;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiEkstra extends Controller
{
    public function index(): View
    {
        $listEkstrakurikuler = Ekstrakurikuler::with('penanggungJawab')
                                             ->withCount('pesertas')
                                             ->orderBy('nama_ekstra', 'asc')
                                             ->paginate(10);

        return view('admin.kelola_absensi.daftar_absensi_ekstra', [
            'user' => Auth::user(),
            'listEkstrakurikuler' => $listEkstrakurikuler
        ]);
    }

    public function show_members(Request $request, Ekstrakurikuler $ekstrakurikuler): View
    {
        $query = $ekstrakurikuler->absensi();
        if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('pertemuan', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%")
              ->orWhereDate('tanggal', 'like', "%$search%");
        });
    }
        $data_absensi = $query->get();
        return view('admin.kelola_absensi.kelola_data_absensi', [
            "data_absensi" => $data_absensi,
            'ekskul' => $ekstrakurikuler
        ]);
    }

    public function lihat_detail_absensi($id): View
    {
        $detil_absensi = DetailAbsensi::where('id_absensi', $id)->get();
        $absensi = Absensi::with('ekstrakurikuler')->findOrFail($id);
        return view('admin.kelola_absensi.list_absensi_member', [
            "detil_absensi" => $detil_absensi,
            'ekskul' => $absensi->ekstrakurikuler,
            'id_ekskul' => $absensi,
        ]);
    }
    
    public function hapus_absensi($id_detail_absensi): RedirectResponse
    {
        $id = DetailAbsensi::findOrFail($id_detail_absensi);
        $id->delete();

        return redirect()->route('admin.kelola_absensi.list_absensi_member')->with('success', 'Data berhasil dihapus!');
    }

    public function updateStatusKehadiran_admin(Request $request, DetailAbsensi $detailAbsensi, Pengguna $pengguna): RedirectResponse
    {
        // Otorisasi: Pastikan PJ yang login adalah PJ dari ekstrakurikuler sesi ini
        $validated = $request->validate([
            'status' => ['required', 'string', \Illuminate\Validation\Rule::in(['hadir', 'izin', 'sakit', 'alpha', 'absen'])],
        ]);

        if ($detailAbsensi->id_pengguna === $pengguna->nim) {
            $detailAbsensi->update([
                'status' => $request->input('status'),
        ]);
        }

        return back()->with('success', 'Status kehadiran berhasil diperbarui!');
    }

    public function show_members_detail(Request $request, $id): View
        {
        $query = DetailAbsensi::where('id_absensi', $id);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('pengguna', function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                ->orWhere('nim', 'like', "%$search%");
            });
        }

        $data_absensi = $query->get();
        $ekstrakurikuler = Absensi::with('ekstrakurikuler')->findOrFail($id)->ekstrakurikuler;

        return view('admin.kelola_absensi.list_absensi_member', [
            "detil_absensi" => $data_absensi,
            'ekskul' => $ekstrakurikuler,
            'id_ekskul' => Absensi::findOrFail($id),
        ]);
    }
    public function clear_all_absensi($id): RedirectResponse
    {
    DetailAbsensi::where('id_absensi', $id)->delete();

    return redirect()->back()->with('success', 'Semua data absensi berhasil dihapus.');
    }

}
