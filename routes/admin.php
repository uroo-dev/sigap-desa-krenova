<?php

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\JenisSuratController;
use App\Http\Controllers\Admin\KategoriLaporanController;
use App\Http\Controllers\Admin\PengaturanDesaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WilayahController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['role:admin'])
    ->group(function (): void {
        Route::get('/', [DashboardAdminController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('wilayah', WilayahController::class)->except(['show']);
        Route::resource('kategori-laporan', KategoriLaporanController::class)->except(['show']);
        Route::resource('jenis-surat', JenisSuratController::class)->except(['show']);
        Route::resource('berita', BeritaController::class)
            ->parameters(['berita' => 'berita'])
            ->except(['show']);

        Route::get('pengaturan-desa', [PengaturanDesaController::class, 'edit'])->name('pengaturan.edit');
        Route::put('pengaturan-desa', [PengaturanDesaController::class, 'update'])->name('pengaturan.update');
    });
