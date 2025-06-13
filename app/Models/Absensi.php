<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';
    public $timestamps = false;

    /**
     * Atribut yang dapat diisi.
     * Ejaan di sini HARUS SAMA PERSIS dengan nama kolom di tabel 'absensi' Anda.
     */
    protected $fillable = [
        'id_ekstrakurikuler', // <-- PASTIKAN EJAAN INI BENAR (dengan 's', bukan 't')
        'tanggal',
        'pertemuan',
        'materi',
        'path'
    ];

    /**
     * Mendapatkan semua record detail (peserta) yang ada di sesi absensi ini.
     */
    public function detailAbsensi(): HasMany
    {
        return $this->hasMany(DetailAbsensi::class, 'id_absensi', 'id_absensi');
    }

    /**
     * Mendapatkan data ekstrakurikuler dari sesi absensi ini.
     */
    public function ekstrakurikuler(): BelongsTo
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    /**
     * Relasi untuk menghitung jumlah hadir dengan withCount di controller
     */
    public function pesertaHadir(): HasMany
    {
        return $this->detailAbsensi()->where('status', 'hadir');
    }
}