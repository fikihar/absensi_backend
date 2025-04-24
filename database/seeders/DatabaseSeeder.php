<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@absenin.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Guru
        $guruUser = User::create([
            'name' => 'Guru A',
            'email' => 'guru@absenin.com',
            'password' => Hash::make('password123'),
            'role' => 'guru',
        ]);
        Guru::create([
            'user_id' => $guruUser->id,
            'nama' => 'Guru A',
        ]);

        // Siswa
        $siswaUser = User::create([
            'name' => 'Siswa X',
            'email' => 'siswa@absenin.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);
        Siswa::create([
            'user_id' => $siswaUser->id,
            'nis' => '123456',
            'nama' => 'Siswa X',
        ]);
    }
}
