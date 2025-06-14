<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\DetailAbsensi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Null_;

class MateriController extends Controller
{
    public function show(): View
    {
        $listMateri = Absensi::all();
    
        return view('admin.materi.daftar_materi', [
            "data_materi" => $listMateri
        ]);
    }
    public function hapus_materi($id_detail_absensi): RedirectResponse
    {
    $absensi = Absensi::findOrFail($id_detail_absensi);
    
    $absensi->path = null;
    $absensi->save();

    return redirect()->route('admin.daftar_materi_ekstra')->with('success', 'Materi berhasil dihapus!');
    }
    public function clear_all_materi(): RedirectResponse
    {
        // Jika tidak ada relasi, baru hapus semua absensi
        Absensi::query()->update(['path' => null]);
        return redirect()->back()->with('success', 'Semua data absensi berhasil dihapus.');
    }
}
