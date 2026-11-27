<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PotensiDesaController extends Controller
{
    public function index(): View
    {
        // Menggunakan data placeholder sementara sebelum tabel potensi dibuat pada modul Admin Lanjutan
        return view('publik.potensi', [
            'wisata' => [],
            'umkm' => [],
            'fasilitas' => [],
        ]);
    }
}
