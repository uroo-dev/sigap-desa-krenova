<?php

use App\Http\Controllers\Publik\BerandaController;
use App\Http\Controllers\Publik\InformasiDesaController;
use App\Http\Controllers\Publik\LaporanPublikController;
use App\Http\Controllers\Publik\PetaDesaController;
use App\Http\Controllers\Publik\PotensiDesaController;
use Illuminate\Support\Facades\Route;

// Rute portal publik tanpa memerlukan autentikasi
Route::get('/', [BerandaController::class, 'index'])->name('home');
Route::get('/peta-desa', [PetaDesaController::class, 'index'])->name('publik.peta');
Route::get('/potensi-desa', [PotensiDesaController::class, 'index'])->name('publik.potensi');
Route::get('/informasi-desa', [InformasiDesaController::class, 'index'])->name('publik.informasi');
Route::get('/informasi-desa/{slug}', [InformasiDesaController::class, 'show'])->name('publik.informasi.detail');
Route::get('/laporan-publik', [LaporanPublikController::class, 'index'])->name('publik.laporan');
Route::get('/laporan-publik/{laporan}', [LaporanPublikController::class, 'show'])->name('publik.laporan.detail');
