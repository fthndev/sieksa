<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengguna extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nim', 'nama', 'email', 'telepon', 'role', 'id_ektrakulikuler'];

    public function akun(): HasOne
    {
        return $this->hasOne(Akun::class, 'nim');
    }

    public function ekstrakulikuler()
    {
        return $this->belongsTo(Ekstrakulikuler::class, 'id_ektrakulikuler');
    }
}