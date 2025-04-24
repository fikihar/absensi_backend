<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa'; // Nama tabel eksplisit
    protected $fillable = ['user_id', 'nis', 'nama', 'kelas'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
