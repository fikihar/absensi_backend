<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dudi extends Model
{
    protected $table = 'dudi';
    protected $fillable = ['nama', 'alamat', 'kontak'];

    public function alokasiSiswa()
    {
        return $this->hasMany(AlokasiSiswa::class);
    }

    public function alokasiGuru()
    {
        return $this->hasMany(AlokasiGuru::class);
    }
}
