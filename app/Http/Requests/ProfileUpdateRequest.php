<?php

namespace App\Http\Requests; // Atau App\Http\Requests\Auth jika itu lokasi file Breeze

use App\Models\Pengguna; // Gunakan model Pengguna
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        /** @var \App\Models\Akun $akun */
        $akun = $this->user(); // $this->user() di FormRequest akan mengembalikan instance Akun
        $penggunaId = $akun->pengguna ? $akun->pengguna->nim : null; // Dapatkan NIM pengguna yang berelasi

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                // Validasi unique pada tabel 'pengguna', kolom 'email',
                // abaikan record dengan 'nim' saat ini.
                Rule::unique(Pengguna::class, 'email')->ignore($penggunaId, 'nim'),
            ],
            // Tambahkan validasi untuk field lain jika ada (misalnya 'telepon')
            // 'telepon' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Setelah validasi, Anda bisa menambahkan data pengguna yang berelasi ke data tervalidasi
     * jika controllernya mengharapkan semua data ada di $request->validated() untuk di-fill.
     * Namun, karena kita fill $pengguna di controller, ini mungkin tidak perlu.
     * Cukup pastikan rules() mengembalikan key yang benar ('name', 'email').
     */
    // public function validated($key = null, $default = null)
    // {
    //     $validated = parent::validated($key, $default);
    //     // Jika perlu, Anda bisa memanipulasi data tervalidasi di sini
    //     return $validated;
    // }
}