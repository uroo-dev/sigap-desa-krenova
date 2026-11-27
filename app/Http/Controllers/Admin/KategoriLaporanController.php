<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriLaporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class KategoriLaporanController extends Controller
{
    public function index(): View
    {
        return view('admin.kategori-laporan.index', [
            'kategori' => KategoriLaporan::latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.kategori-laporan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'ikon' => ['nullable', 'string', 'max:64'],
            'aktif' => ['sometimes', 'boolean'],
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['nama']);
        $data['aktif'] = $request->has('aktif') ? $request->boolean('aktif') : true;

        KategoriLaporan::create($data);

        return redirect()->route('admin.kategori-laporan.index')
            ->with('success', 'Kategori dibuat.');
    }

    public function edit(KategoriLaporan $kategoriLaporan): View
    {
        return view('admin.kategori-laporan.edit', ['kategori' => $kategoriLaporan]);
    }

    public function update(Request $request, KategoriLaporan $kategoriLaporan): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'ikon' => ['nullable', 'string', 'max:64'],
            'aktif' => ['sometimes', 'boolean'],
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['nama'], $kategoriLaporan->id);
        $data['aktif'] = $request->boolean('aktif');

        $kategoriLaporan->update($data);

        return redirect()->route('admin.kategori-laporan.index')
            ->with('success', 'Kategori diperbarui.');
    }

    public function destroy(KategoriLaporan $kategoriLaporan): RedirectResponse
    {
        $kategoriLaporan->delete();

        return back()->with('success', 'Kategori dihapus.');
    }

    private function generateUniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($nama);
        $slug = $baseSlug;
        $counter = 1;

        while (
            KategoriLaporan::where('slug', $slug)
                ->when($ignoreId !== null, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
