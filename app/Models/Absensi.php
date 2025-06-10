<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';

    protected $fillable = ['id_ekstrakulikuler', 'tanggal', 'pertemuan', 'materi', 'status', 'keterangan'];

    public function detailAbsensi()
    {
        return $this->hasMany(DetailAbsensi::class, 'id_absensi');
    }

    public function ekstrakulikuler()
    {
        return $this->belongsTo(Ekstrakulikuler::class, 'id_ekstrakulikuler');
    }
}

