<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlokasiSiswa extends Model
{
    protected $table = 'alokasi_siswa';
    protected $fillable = ['siswa_id', 'dudi_id', 'tanggal_mulai', 'tanggal_selesai'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }
}
