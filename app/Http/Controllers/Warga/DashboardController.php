<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Anda bisa passing data spesifik untuk warga ke view ini
        return view('warga.dashboard'); // Buat file ini: resources/views/warga/dashboard.blade.php
    }
}