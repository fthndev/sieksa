<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PendampingController extends Controller
{
    public function index()
    {
        // Ambil semua musahhil (pj dan musahil) beserta ekstrakurikulernya
        $musahhilList = Pengguna::whereIn('role', ['pj', 'musahil'])
                                ->with('ekstrakurikuler')
                                ->get();
    
        // Ambil semua warga
        $wargaList = Pengguna::where('role', 'warga')->get();
    
        // Ambil NIM warga yang sudah punya pendamping dari tabel musahil_pendamping
        $nimWargaSudahDidampingi = DB::table('musahil_pendamping')->pluck('id_warga');
    
        // Ambil warga yang belum memiliki pendamping
        $wargaTanpaPendamping = Pengguna::where('role', 'warga')
                                        ->whereNotIn('nim', $nimWargaSudahDidampingi)
                                        ->get();
    
        return view('admin.pendamping.index', compact('musahhilList', 'wargaList', 'wargaTanpaPendamping'));
    }
    
    
    public function assign(Request $request)
{
    $request->validate([
        'musahhil_nim' => 'required|exists:pengguna,nim',
        'warga_nim' => 'required|exists:pengguna,nim',
    ]);

    // Update kolom id_pendamping warga
    Pengguna::where('nim', $request->warga_nim)->update([
        'id_pendamping' => $request->musahhil_nim,
    ]);

    return back()->with('success', 'Pendamping berhasil ditetapkan.');
}
public function wargaDidampingi($nim)
{
    // Ambil data musahhil berdasarkan NIM
    $musahhil = Pengguna::where('nim', $nim)
        ->whereIn('role', [ 'pj','musahil'])
        ->firstOrFail();

    // Ambil NIM warga yang didampingi dari tabel pivot musahil_pendamping
    $wargaNims = DB::table('musahil_pendamping')
        ->where('id_musahil_pendamping', $nim)
        ->pluck('id_warga');

    // Ambil data lengkap warga dari tabel pengguna
    $wargaList = Pengguna::whereIn('nim', $wargaNims)
        ->where('role', 'warga')
        ->get();

    return view('admin.pendamping.warga_didampingi', compact('musahhil', 'wargaList'));
}
public function edit($nim)
{
    $warga = Pengguna::where('nim', $nim)->firstOrFail();
    $musahhilList = Pengguna::whereIn('role', ['pj', 'musahhil'])->get();

    return view('admin.pendamping.edit', compact('warga', 'musahhilList'));
}


public function tambahPendamping(Request $request)
{
    
    $request->validate([
        'nim_musahhil' => 'required|exists:pengguna,nim',
        'nim_warga' => 'required|exists:pengguna,nim',
    ]);

    // Ambil musahhil dan warga berdasarkan NIM
    $musahhil = DB::table('pengguna')->where('nim', $request->nim_musahhil)->first();
    $warga = DB::table('pengguna')->where('nim', $request->nim_warga)->first();
    if (!$musahhil || !$warga) {
        return redirect()->back()->with('error', 'Musahhil atau Warga tidak ditemukan.');
    }

    // Cek apakah warga sudah punya pendamping
    $sudah = DB::table('musahil_pendamping')->where('id_warga', $warga->nim)->exists();
    if ($sudah) {
        return redirect()->back()->with('error', 'Warga ini sudah memiliki musahhil pendamping.');
    }

    // Insert ke tabel musahil_pendamping
    DB::table('musahil_pendamping')->insert([
        'id_musahil_pendamping' => $musahhil->nim,
        'id_warga' => $warga->nim,
    ]);
    

    return redirect()->back()->with('success', 'Pendamping berhasil ditambahkan.');
}
public function destroy($nim)
{
    // Hapus data di tabel musahil_pendamping berdasarkan NIM warga
    DB::table('musahil_pendamping')->where('id_warga', $nim)->delete();

    return redirect()->back()->with('success', 'Pendampingan warga berhasil dihapus.');
}


}

