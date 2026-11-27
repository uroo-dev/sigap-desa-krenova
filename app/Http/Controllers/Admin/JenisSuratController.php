<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JenisSuratController extends Controller
{
    public function index(): View
    {
        return view('admin.jenis-surat.index', [
            'jenis' => JenisSurat::latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.jenis-surat.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'persyaratan' => ['nullable', 'array'],
            'persyaratan.*' => ['string', 'max:100'],
            'template_isi' => ['nullable', 'string'],
            'aktif' => ['sometimes', 'boolean'],
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['nama']);
        $data['aktif'] = $request->has('aktif') ? $request->boolean('aktif') : true;

        JenisSurat::create($data);

        return redirect()->route('admin.jenis-surat.index')
            ->with('success', 'Jenis surat dibuat.');
    }

    public function edit(JenisSurat $jenisSurat): View
    {
        return view('admin.jenis-surat.edit', ['jenis' => $jenisSurat]);
    }

    public function update(Request $request, JenisSurat $jenisSurat): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'persyaratan' => ['nullable', 'array'],
            'persyaratan.*' => ['string', 'max:100'],
            'template_isi' => ['nullable', 'string'],
            'aktif' => ['sometimes', 'boolean'],
        ]);

        $data['slug'] = $this->generateUniqueSlug($data['nama'], $jenisSurat->id);
        $data['aktif'] = $request->boolean('aktif');

        $jenisSurat->update($data);

        return redirect()->route('admin.jenis-surat.index')
            ->with('success', 'Jenis surat diperbarui.');
    }

    public function destroy(JenisSurat $jenisSurat): RedirectResponse
    {
        try {
            $jenisSurat->delete();

            return back()->with('success', 'Jenis surat berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Jenis surat tidak dapat dihapus karena masih digunakan oleh pengajuan surat.');
        }
    }

    private function generateUniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($nama);
        $slug = $baseSlug;
        $counter = 1;

        while (
            JenisSurat::where('slug', $slug)
                ->when($ignoreId !== null, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
