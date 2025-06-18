<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class EkstrakurikulerDetailController extends Controller
{
/**
         * Menampilkan halaman detail untuk ekstrakurikuler yang dipilih.
         *
         * @param  \App\Models\Ekstrakurikuler  $ekstrakurikuler  Instance model yang di-resolve oleh Route Model Binding
         * @return \Illuminate\View\View
         */
        public function show(Ekstrakurikuler $ekstrakurikuler): View
        {
            /** @var \App\Models\Pengguna|null $currentUser */
            $currentUser = Auth::user();
            $ekstrakurikuler_data = Ekstrakurikuler::all();
            $isMengikutiSebagaiUtama = false;

            if ($currentUser && $currentUser->id_ektrakulikuler == $ekstrakurikuler->id_ekstrakulikuler) {
                $isMengikutiSebagaiUtama = true;
            }
        $user = Auth::user(); // Mendapatkan instance Pengguna yang sedang login

        // Pastikan pengguna ada dan memiliki atribut 'role'
        if ($user && isset($user->role)) {
            // Menggunakan trim() dan strtolower() untuk perbandingan yang lebih aman
            switch (trim(strtolower($user->role))) {
                case 'warga':
                    // Pastikan route 'warga.dashboard' sudah ada di routes/web.php
                    $user_role = 'warga';
                    break;
                case 'musahil':
                    // Pastikan route 'musahil.dashboard' sudah ada di routes/web.php
                    $user_role = 'musahil';
                    break;
                case 'pj':
                    // Pastikan route 'pj.dashboard' sudah ada di routes/web.php
                    $user_role = 'pj';
                    break;
                default:
                    $user_role = 'null';
                    break;
            }
        }

        return view($user_role.'.ekstrakurikuler', [
                'ekskul' => $currentUser->ekstrakurikuler,
                'isMengikutiSebagaiUtama' => $isMengikutiSebagaiUtama
        ]);
        }
        public function tambahekstra(Ekstrakurikuler $ekskul){
            $user = Auth::user();

            if (!$user){
                return redirect()->back()->with('error', 'Gagal: Pengguna tidak ditemukan');
            }

            if ($user->id_ekstrakurikuler){
                return redirect()->back()->with('error', 'Gagal: Anda sudah mendaftar Ekstrakurikuler');
            }
            if ($ekskul->status==='tutup'){
                return redirect()->back()->with('error', 'Gagal: Ekstrakurikuler belum dibuka');
            }

            try {
                $user->id_ekstrakurikuler = $ekskul->id_ekstrakurikuler;
                $user->save();
            } catch (\Exception $e) {
                dd([
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }

            return redirect()->route('warga.dashboard')->with('success', 'Berhasil mendaftar Ekstrakurikuler');
        }

}
