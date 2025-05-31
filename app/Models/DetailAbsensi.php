<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailAbsensi extends Model
{
    protected $table = 'detail_absensi';
    protected $primaryKey = 'id_detail_absensi';

    protected $fillable = ['id_absensi', 'id_pengguna', 'status', 'note'];

    public function absensi()
    {
        return $this->belongsTo(Absensi::class, 'id_absensi');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'nim');
    }
}

