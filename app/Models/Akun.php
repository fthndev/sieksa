<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Akun extends Model
{
    use HasFactory;

    protected $table = 'akun';
    protected $primaryKey = 'id_akun';
    public $timestamps = false;

    protected $fillable = ['nim', 'password', 'remember_token'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['password' => 'hashed']; // Otomatis hash saat diset

    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(Pengguna::class, 'nim', 'nim');
    }
}