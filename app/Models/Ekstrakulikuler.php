<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekstrakulikuler extends Model
{
    protected $table = 'ekstrakulikuler';
    protected $primaryKey = 'id_ekstrakulikuler';

    protected $fillable = ['nama_ekstra', 'hari', 'jam', 'kouta', 'ketrangan'];

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_ektrakulikuler');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'id_ekstrakulikuler');
    }

    public function pemateri()
    {
        return $this->hasMany(Pemateri::class, 'id_ekstrakulikuler');
    }
}

