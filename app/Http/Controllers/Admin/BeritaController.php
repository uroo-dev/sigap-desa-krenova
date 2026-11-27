<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BeritaController extends Controller
{
    public function index(): View
    {
        return view('admin.berita.index', [
            'berita' => Berita::latest()->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.berita.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'ringkasan' => ['nullable', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'tipe' => ['required', 'in:berita,pengumuman,agenda'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['slug'] = Str::slug($data['judul']).'-'.Str::lower(Str::random(6));
        $data['user_id'] = Auth::id();

        Berita::create($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Konten dibuat.');
    }

    public function edit(Berita $berita): View
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita): RedirectResponse
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:200'],
            'ringkasan' => ['nullable', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'tipe' => ['required', 'in:berita,pengumuman,agenda'],
            'published_at' => ['nullable', 'date'],
        ]);

        $berita->update($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Konten diperbarui.');
    }

    public function destroy(Berita $berita): RedirectResponse
    {
        $berita->delete();

        return back()->with('success', 'Konten dihapus.');
    }
}
