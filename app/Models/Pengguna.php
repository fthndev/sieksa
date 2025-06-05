<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Ditambahkan untuk ekstrakurikulerDikelola
use Illuminate\Notifications\Notifiable;
use App\Models\Akun; // <-- Di-uncomment atau ditambahkan
use App\Models\Ekstrakurikuler; // <-- Di-uncomment atau ditambahkan

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim', 'nama', 'email', 'telepon', 'role',
        'id_ekstrakurikuler', // Sesuai dengan nama kolom di database Anda
    ];

    protected $hidden = [ /* Tidak ada password atau token di sini */ ];
    protected $casts = [ /* 'email_verified_at' => 'datetime', */ ];

    public function akun(): HasOne
    {
        return $this->hasOne(Akun::class, 'nim', 'nim');
    }

    public function ekstrakurikuler(): BelongsTo
    {
        return $this->belongsTo(Ekstrakurikuler::class, 'id_ekstrakurikuler', 'id_ekstrakurikuler');
    }

    public function getAuthPassword()
    {
        return optional($this->akun)->password;
    }

    public function getAuthIdentifierName()
    {
        return 'nim';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getRememberToken()
    {
        return optional($this->akun)->{$this->getRememberTokenName()};
    }

    public function setRememberToken($value)
    {
        if ($this->akun instanceof Akun) {
            $this->akun->{$this->getRememberTokenName()} = $value;
            $this->akun->save();
        }
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function wargaDidampingi(): BelongsToMany
    {
        return $this->belongsToMany(
            Pengguna::class,
            'musahil_pendamping',
            'id_musahil_pendamping',
            'id_warga',
            'nim',
            'nim'
        );
    }

    public function musahilPendampingnya(): BelongsToMany
    {
        return $this->belongsToMany(
            Pengguna::class,
            'musahil_pendamping',
            'id_warga',
            'id_musahil_pendamping',
            'nim',
            'nim'
        );
    }

    /**
     * Mendapatkan daftar Ekstrakurikuler yang menjadi tanggung jawab Pengguna ini (jika Pengguna ini adalah PJ).
     */
    public function ekstrakurikulerDikelola(): HasMany // Tambahkan tipe return HasMany
    {
        // Kolom 'id_pj' di tabel 'ekstrakurikuler' merujuk ke 'nim' (PK) di tabel 'pengguna' ini.
        return $this->hasMany(Ekstrakurikuler::class, 'id_pj', 'nim');
    }
}