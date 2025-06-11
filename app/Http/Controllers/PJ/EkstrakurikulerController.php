<?php

namespace App\Http\Controllers\Pj;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EkstrakurikulerController extends Controller
{
    public function lihatPeserta(Request $request, $id): View
{
    $nim = $request->query('nim'); // opsional, jika ingin filter berdasarkan NIM

    // Ambil semua pengguna yang mengikuti ekstrakurikuler tertentu
    $listPeserta = Pengguna::where('id_ekstrakurikuler', $id)
    ->whereIn('role', ['warga', 'musahil']) // Tambahan filter role
    ->when($nim, function ($query, $nim) {
        return $query->where('nim', $nim);
    })
        ->select('nim', 'nama', 'email', 'telepon', 'role')
        ->orderBy('nama', 'asc')
        ->get();

    // Ambil data ekstrakurikuler jika ingin ditampilkan di view
    $ekskul = Ekstrakurikuler::findOrFail($id);

    return view('pj.ekstrakurikuler.peserta', [
        'ekskul' => $ekskul,
        'listPeserta' => $listPeserta,
    ]);
}
}