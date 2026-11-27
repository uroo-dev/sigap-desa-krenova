<?php

namespace App\Http\Controllers\Publik;

use App\Enums\LaporanStatus;
use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Laporan;
use App\Models\Wilayah;
use Illuminate\View\View;

class BerandaController extends Controller
{
    public function index(): View
    {
        return view('publik.beranda', [
            'desa' => Wilayah::where('tipe', 'desa')->first(),
            'beritaTerbaru' => Berita::published()->latest('published_at')->take(3)->get(),
            'totalLaporan' => Laporan::count(),
            'laporanSelesai' => Laporan::where('status', LaporanStatus::DIVALIDASI_KADES->value)->count(),
        ]);
    }
}
