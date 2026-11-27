<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\View\View;

class PetaDesaController extends Controller
{
    public function index(): View
    {
        $rt = Wilayah::rt()->with('parent')->orderBy('nama')->get();

        return view('publik.peta', [
            'rt' => $rt,
            'desa' => Wilayah::where('tipe', 'desa')->first(),
        ]);
    }
}
