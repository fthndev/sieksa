<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Tambahkan import ini
// use App\Models\Pengguna; // Tidak wajib jika hanya sebagai tipe return atau di ::class

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikuler';
    protected $primaryKey = 'id_ekstrakurikuler';
    public $timestamps = false;

    protected $fillable = [
        'nama_ekstra',
        'hari',
        'jam',
        'kuota',
        'keterangan',
        'id_pj' // <-- TAMBAHKAN id_pj ke fillable
    ];

    /**
     * Mendapatkan semua pengguna (peserta) yang mengikuti ekstrakurikuler ini.
     */
    public function pesertas(): HasMany // Nama relasi diubah dari pengguna() menjadi pesertas() agar lebih jelas
    {
        return $this->hasMany(Pengguna::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    /**
     * Mendapatkan semua record absensi yang terkait dengan ekstrakurikuler ini.
     */
    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    /**
     * Mendapatkan semua pemateri yang terkait dengan ekstrakurikuler ini.
     */
    public function pemateri(): HasMany
    {
        return $this->hasMany(Pemateri::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    /**
     * Mendapatkan data Pengguna yang menjadi Penanggung Jawab (PJ) untuk ekstrakurikuler ini.
     * Satu Ekstrakurikuler dimiliki/dikelola oleh satu PJ (Pengguna).
     */
    public function penanggungJawab(): BelongsTo // Atau bisa dinamai pj() jika lebih suka
    {
        // Kolom 'id_pj' di tabel 'ekstrakurikuler' ini adalah foreign key
        // yang merujuk ke kolom 'nim' (owner key/primary key) di tabel 'pengguna'.
        return $this->belongsTo(Pengguna::class, 'id_pj', 'nim');
    }

    /**
     * Method untuk Route Model Binding jika primary key bukan 'id'.
     */
    public function getRouteKeyName()
    {
        return 'id_ekstrakurikuler';
    }
}