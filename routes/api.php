<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AdminSiswaController;
use App\Http\Controllers\API\AdminGuruController;
use App\Http\Controllers\API\DudiController;
use App\Http\Controllers\API\AlokasiSiswaController;
use App\Http\Controllers\API\AlokasiGuruController;
use App\Http\Controllers\API\AbsensiController;

Route::post('/api/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum', 'update.last.activity', 'check.session.timeout'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/siswa', [AdminSiswaController::class, 'index']);
    Route::post('/admin/siswa', [AdminSiswaController::class, 'store']);
    Route::put('/admin/siswa/{id}', [AdminSiswaController::class, 'update']);
    Route::delete('/admin/siswa/{id}', [AdminSiswaController::class, 'destroy']);

    Route::get('/admin/guru', [AdminGuruController::class, 'index']);
    Route::post('/admin/guru', [AdminGuruController::class, 'store']);
    Route::put('/admin/guru/{id}', [AdminGuruController::class, 'update']);
    Route::delete('/admin/guru/{id}', [AdminGuruController::class, 'destroy']);

    Route::get('/admin/dudi', [DudiController::class, 'index']);
    Route::post('/admin/dudi', [DudiController::class, 'store']);
    Route::put('/admin/dudi/{id}', [DudiController::class, 'update']);
    Route::delete('/admin/dudi/{id}', [DudiController::class, 'destroy']);

    Route::post('/admin/alokasi-siswa', [AlokasiSiswaController::class, 'store']);
    Route::get('/admin/alokasi-siswa', [AlokasiSiswaController::class, 'index']);
    Route::delete('/admin/alokasi-siswa/{id}', [AlokasiSiswaController::class, 'destroy']);

    Route::post('/admin/alokasi-guru', [AlokasiGuruController::class, 'store']);
    Route::get('/admin/alokasi-guru', [AlokasiGuruController::class, 'index']);
    Route::delete('/admin/alokasi-guru/{id}', [AlokasiGuruController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'role:siswa'])->group(function () {
    Route::post('/siswa/absensi', [AbsensiController::class, 'store']);
    Route::get('/siswa/absensi', [AbsensiController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'role:admin,guru'])->group(function () {
    Route::get('/admin-guru/absensi', [AbsensiController::class, 'indexAdminGuru']);
    Route::get('/admin-guru/siswa', [AbsensiController::class, 'listSiswa']);
    Route::get('/admin-guru/laporan-absensi', [AbsensiController::class, 'laporanAbsensi']);
    Route::get('/admin-guru/laporan-absensi/export-pdf', [AbsensiController::class, 'exportPDF']);

});
