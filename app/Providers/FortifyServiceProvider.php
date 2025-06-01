<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Akun;
use Laravel\Fortify\Fortify;


class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $akun = Akun::where('nim', $request->nim)->first();

            if ($akun && Hash::check($request->password, $akun->password)) {
                return $akun;
            }

            return null; 
        });
    }
}

