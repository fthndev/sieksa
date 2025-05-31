<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusahilPendamping extends Model
{
    protected $table = 'musahil_pendamping';
    protected $primaryKey = 'id_pendaping';

    protected $fillable = ['id_musahil_pendamping', 'id_warga'];

    public function musahil()
    {
        return $this->belongsTo(Pengguna::class, 'id_musahil_pendamping', 'nim');
    }

    public function warga()
    {
        return $this->belongsTo(Pengguna::class, 'id_warga', 'nim');
    }
}

