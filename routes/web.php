<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WebAuthController;
use App\Http\Controllers\Web\AdminWebController;
use App\Http\Controllers\Web\GuruWebController;
use App\Http\Controllers\Web\SiswaWebController;

// ====== Login Routes ======
Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [WebAuthController::class, 'login'])->name('login');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// ====== Protected Routes (Harus Login) ======
Route::middleware('auth')->group(function () {

    // --- ADMIN ---
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminWebController::class, 'index'])->name('dashboard');

        // Manajemen Siswa
        Route::get('/siswa', [AdminWebController::class, 'siswaIndex'])->name('siswa.index');
        Route::post('/siswa', [AdminWebController::class, 'siswaStore'])->name('siswa.store');
        Route::put('/siswa/{id}', [AdminWebController::class, 'siswaUpdate'])->name('siswa.update');
        Route::delete('/siswa/{id}', [AdminWebController::class, 'siswaDestroy'])->name('siswa.destroy');

        // Manajemen Guru
        Route::get('/guru', [AdminWebController::class, 'guruIndex'])->name('guru.index');
        Route::post('/guru', [AdminWebController::class, 'guruStore'])->name('guru.store');
        Route::put('/guru/{id}', [AdminWebController::class, 'guruUpdate'])->name('guru.update');
        Route::delete('/guru/{id}', [AdminWebController::class, 'guruDestroy'])->name('guru.destroy');

        // Manajemen DUDI
        Route::get('/dudi', [AdminWebController::class, 'dudiIndex'])->name('dudi.index');
        Route::post('/dudi', [AdminWebController::class, 'dudiStore'])->name('dudi.store');
        Route::put('/dudi/{id}', [AdminWebController::class, 'dudiUpdate'])->name('dudi.update');
        Route::delete('/dudi/{id}', [AdminWebController::class, 'dudiDestroy'])->name('dudi.destroy');

        // Alokasi Siswa ke DUDI
        Route::get('/alokasi-siswa', [AdminWebController::class, 'alokasiSiswaIndex'])->name('alokasi-siswa.index');
        Route::post('/alokasi-siswa', [AdminWebController::class, 'alokasiSiswaStore'])->name('alokasi-siswa.store');
        Route::delete('/alokasi-siswa/{id}', [AdminWebController::class, 'alokasiSiswaDestroy'])->name('alokasi-siswa.destroy');

        // Alokasi Guru ke DUDI
        Route::get('/alokasi-guru', [AdminWebController::class, 'alokasiGuruIndex'])->name('alokasi-guru.index');
        Route::post('/alokasi-guru', [AdminWebController::class, 'alokasiGuruStore'])->name('alokasi-guru.store');
        Route::delete('/alokasi-guru/{id}', [AdminWebController::class, 'alokasiGuruDestroy'])->name('alokasi-guru.destroy');

        // Laporan Absensi
        Route::get('/laporan-absensi', [AdminWebController::class, 'laporanAbsensi'])->name('laporan-absensi.index');
        Route::get('/laporan-absensi/export-pdf', [AdminWebController::class, 'exportAbsensiPdf'])->name('laporan-absensi.export');
    });

    // --- GURU ---
    Route::prefix('admin-guru')->name('guru.')->middleware('role:guru')->group(function () {
        Route::get('/dashboard', [GuruWebController::class, 'index'])->name('dashboard');

        // Absensi
        Route::get('/absensi', [GuruWebController::class, 'absensiIndex'])->name('absensi.index');

        // Daftar Siswa
        Route::get('/siswa', [GuruWebController::class, 'siswaIndex'])->name('siswa.index');

        // Laporan Absensi
        Route::get('/laporan-absensi', [GuruWebController::class, 'laporanAbsensi'])->name('laporan-absensi.index');
        Route::get('/laporan-absensi/export-pdf', [GuruWebController::class, 'exportAbsensiPdf'])->name('laporan-absensi.export');
    });

    // --- SISWA ---
    Route::prefix('siswa')->name('siswa.')->middleware('role:siswa')->group(function () {
        Route::get('/dashboard', [SiswaWebController::class, 'index'])->name('dashboard');

        // Absensi
        Route::get('/absensi', [SiswaWebController::class, 'absensiIndex'])->name('absensi.index');
        Route::post('/absensi', [SiswaWebController::class, 'absensiStore'])->name('absensi.store');

        // Isi Form Absensi
        Route::get('/absensi/create', [SiswaWebController::class, 'create'])->name('absensi.create');
    });

});
