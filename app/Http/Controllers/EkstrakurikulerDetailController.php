<?php
namespace App\Http\Controllers;
    use App\Models\Ekstrakurikuler; // Pastikan model Ekstrakurikuler di-import
    use Illuminate\Http\Request;    // Bisa dihapus jika tidak digunakan di method show
    use Illuminate\View\View;
    use Illuminate\Support\Facades\Auth; // Untuk mendapatkan info pengguna yang login

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
    }