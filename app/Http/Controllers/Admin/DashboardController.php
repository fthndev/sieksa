<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        // --- Mengambil Data untuk Kartu Statistik ---
        $statistik = [
            'totalPengguna' => Pengguna::where('role', '!=', 'admin')->count(),
            'totalEkstrakurikuler' => Ekstrakurikuler::count(),
            'totalWarga' => Pengguna::where('role', 'warga')->count(),
            'totalMusahil' => Pengguna::where('role', 'musahil')->count(),
            'totalPJ' => Pengguna::where('role', 'pj')->count(),
        ];

        // --- Menyiapkan Data untuk Grafik Distribusi Role ---
        $roleCounts = Pengguna::where('role', '!=', 'admin')
            ->groupBy('role')
            ->select('role', DB::raw('count(*) as total'))
            ->pluck('total', 'role');

        $chartRoleData = [
            'labels' => $roleCounts->keys()->map(fn($role) => ucwords($role)),
            'data' => $roleCounts->values(),
        ];

        // --- Menyiapkan Data untuk Grafik Jumlah Peserta per Ekskul ---
        $ekskulPeserta = Ekstrakurikuler::withCount('pesertas')
            ->orderBy('pesertas_count', 'desc')
            ->limit(10) // Ambil 10 ekskul dengan peserta terbanyak
            ->get();

        $chartEkskulData = [
            'labels' => $ekskulPeserta->pluck('nama_ekstra'),
            'data' => $ekskulPeserta->pluck('pesertas_count'),
        ];

        return view('admin.dashboard', [
            'user' => Auth::user(),
            'statistik' => $statistik,
            'chartRoleData' => ($chartRoleData), // Kirim sebagai JSON
            'chartEkskulData' => ($chartEkskulData), // Kirim sebagai JSON
        ]);
    }
}