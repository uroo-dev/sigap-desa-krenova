<?php

namespace App\Http\Controllers;

use App\Enums\RoleName;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class DashboardController extends Controller
{
    /**
     * Arahkan pengguna ke dashboard sesuai role masing-masing.
     */
    public function index(): RedirectResponse
    {
        $user = Auth::user();

        $targetRoute = match (true) {
            $user->hasRole(RoleName::ADMIN->value) => 'admin.dashboard',
            $user->hasRole(RoleName::KEPALA_DESA->value) => 'kades.dashboard',
            $user->hasRole(RoleName::KETUA_RT->value) => 'rt.dashboard',
            default => 'masyarakat.dashboard',
        };

        if (Route::has($targetRoute)) {
            return redirect()->route($targetRoute);
        }

        // Fallback sementara sebelum modul dashboard role non-admin ditambahkan
        return redirect()->route('home');
    }
}
