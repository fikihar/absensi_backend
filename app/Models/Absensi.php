<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = [
        'siswa_id', 'foto', 'latitude', 'longitude', 'lokasi', 'jurnal', 'tanggal'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
