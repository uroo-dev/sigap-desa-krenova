<?php

namespace App\Http\Controllers\Publik;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\View\View;

class InformasiDesaController extends Controller
{
    public function index(): View
    {
        return view('publik.informasi', [
            'berita' => Berita::published()->where('tipe', 'berita')->latest('published_at')->paginate(10),
            'pengumuman' => Berita::published()->where('tipe', 'pengumuman')->latest('published_at')->take(5)->get(),
            'agenda' => Berita::published()->where('tipe', 'agenda')->latest('published_at')->take(5)->get(),
        ]);
    }

    public function show(string $slug): View
    {
        $berita = Berita::published()->where('slug', $slug)->firstOrFail();

        return view('publik.informasi-detail', compact('berita'));
    }
}
