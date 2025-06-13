<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $statistik = [
            'totalPengguna' => Pengguna::count(),
            'totalEkstrakurikuler' => Ekstrakurikuler::count(),
            'totalWarga' => Pengguna::where('role', 'warga')->count(),
            'totalMusahil' => Pengguna::where('role', 'musahil')->count(),
            'totalPJ' => Pengguna::where('role', 'pj')->count(),
        ];

        return view('admin.dashboard', [
            'user' => Auth::user(),
            'statistik' => $statistik,
        ]);
    }
}