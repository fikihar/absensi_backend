<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WebAuthController;
use App\Http\Controllers\Web\AdminWebController;
use App\Http\Controllers\Web\GuruWebController;
use App\Http\Controllers\Web\SiswaWebController;

Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [WebAuthController::class, 'login'])->name('login');
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
// Route dashboard berdasarkan role

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminWebController::class, 'index'])->name('admin.dashboard');
    Route::get('/guru/dashboard', [GuruWebController::class, 'index'])->name('guru.dashboard');
    Route::get('/siswa/dashboard', [SiswaWebController::class, 'index'])->name('siswa.dashboard');
});

