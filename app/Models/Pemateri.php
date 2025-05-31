<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemateri extends Model
{
    protected $table = 'pemateri';
    protected $primaryKey = 'id_pemateri';

    protected $fillable = ['nama', 'id_ekstrakulikuler'];

    public function ekstrakulikuler()
    {
        return $this->belongsTo(Ekstrakulikuler::class, 'id_ekstrakulikuler');
    }
}

