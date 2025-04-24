<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlokasiGuru extends Model
{
    protected $table = 'alokasi_guru';
    protected $fillable = ['guru_id', 'dudi_id', 'tanggal_mulai', 'tanggal_selesai'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function dudi()
    {
        return $this->belongsTo(Dudi::class);
    }
}
