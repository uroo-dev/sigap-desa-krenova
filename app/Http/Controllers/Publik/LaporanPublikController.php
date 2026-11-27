<?php

namespace App\Http\Controllers\Publik;

use App\Enums\LaporanStatus;
use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\View\View;

class LaporanPublikController extends Controller
{
    public function index(): View
    {
        $laporan = Laporan::with(['kategori', 'rt'])
            ->whereNotIn('status', [
                LaporanStatus::BARU->value,
                LaporanStatus::DITOLAK_RT->value,
            ])
            ->latest()
            ->paginate(15);

        return view('publik.laporan', compact('laporan'));
    }

    public function show(Laporan $laporan): View
    {
        // Jangan tampilkan laporan yang belum diverifikasi atau ditolak oleh RT
        abort_if(
            in_array($laporan->status, [LaporanStatus::BARU, LaporanStatus::DITOLAK_RT], true),
            404
        );

        // Hanya muat relasi publik; jangan pernah memuat relasi user demi menjaga anonimitas pelapor
        $laporan->load(['kategori', 'rt']);

        return view('publik.laporan-detail', compact('laporan'));
    }
}
