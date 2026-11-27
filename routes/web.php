<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Portal publik (tanpa login)
require __DIR__.'/publik.php';

// Autentikasi lokal & Google OAuth
require __DIR__.'/auth.php';

// Area terautentikasi per role
Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    require __DIR__.'/admin.php';
    // require __DIR__.'/masyarakat.php'; // Pekerjaan 3
    // require __DIR__.'/rt.php';         // Pekerjaan 4
    // require __DIR__.'/kades.php';      // Pekerjaan 5
});
