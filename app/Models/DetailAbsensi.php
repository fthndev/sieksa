<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailAbsensi extends Model
{
    use HasFactory;

    protected $table = 'detail_absensi';
    protected $primaryKey = 'id_detail_absensi';

    /**
     * Menandakan apakah model menggunakan timestamps (created_at, updated_at).
     * Set ke false karena tabel Anda tidak memilikinya.
     * @var bool
     */
    public $timestamps = false; // <-- INI ADALAH PERBAIKAN UTAMANYA

    protected $fillable = ['id_absensi', 'id_pengguna', 'status', 'note'];

    /**
     * Mendapatkan data absensi (header) yang terkait dengan detail ini.
     */
    public function absensi(): BelongsTo
    {
        return $this->belongsTo(Absensi::class, 'id_absensi', 'id_absensi');
    }

    /**
     * Mendapatkan data pengguna yang terkait dengan detail absensi ini.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'nim');
    }
}