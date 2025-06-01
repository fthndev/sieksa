<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Akun extends Authenticatable
{
    protected $table = 'akun';
    protected $primaryKey = 'id_akun';

    protected $fillable = ['nim', 'password'];
    
    public $timestamps = false;

    protected $hidden = ['password', 'remember_token'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'nim');
    }
}

