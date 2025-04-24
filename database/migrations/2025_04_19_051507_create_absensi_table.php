<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->string('foto')->nullable(); // Path ke foto selfie
            $table->decimal('latitude', 9, 6);  // Koordinat latitude
            $table->decimal('longitude', 9, 6); // Koordinat longitude
            $table->text('lokasi')->nullable(); // Nama lokasi dari Nominatim
            $table->text('jurnal')->nullable(); // Jurnal kegiatan
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
