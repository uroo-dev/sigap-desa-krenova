<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WilayahController extends Controller
{
    public function index(): View
    {
        $wilayah = Wilayah::with('parent')->orderBy('tipe')->orderBy('nama')->get();

        return view('admin.wilayah.index', compact('wilayah'));
    }

    public function create(): View
    {
        return view('admin.wilayah.create', [
            'parents' => Wilayah::whereIn('tipe', ['desa', 'dusun', 'rw'])->orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tipe' => ['required', 'in:desa,dusun,rw,rt'],
            'nama' => ['required', 'string', 'max:100'],
            'parent_id' => ['nullable', 'exists:wilayah,id'],
            'kode' => ['nullable', 'string', 'max:32', 'unique:wilayah,kode'],
            'geojson' => ['nullable', 'json'],
        ]);

        if (isset($data['geojson']) && is_string($data['geojson'])) {
            $data['geojson'] = json_decode($data['geojson'], true);
        }

        Wilayah::create($data);

        return redirect()->route('admin.wilayah.index')
            ->with('success', 'Wilayah ditambahkan.');
    }

    public function edit(Wilayah $wilayah): View
    {
        return view('admin.wilayah.edit', [
            'wilayah' => $wilayah,
            'parents' => Wilayah::where('id', '!=', $wilayah->id)->orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Wilayah $wilayah): RedirectResponse
    {
        $data = $request->validate([
            'tipe' => ['required', 'in:desa,dusun,rw,rt'],
            'nama' => ['required', 'string', 'max:100'],
            'parent_id' => ['nullable', 'exists:wilayah,id', Rule::notIn([$wilayah->id])],
            'kode' => ['nullable', 'string', 'max:32', Rule::unique('wilayah', 'kode')->ignore($wilayah->id)],
            'geojson' => ['nullable', 'json'],
        ]);

        if (isset($data['geojson']) && is_string($data['geojson'])) {
            $data['geojson'] = json_decode($data['geojson'], true);
        }

        $wilayah->update($data);

        return redirect()->route('admin.wilayah.index')
            ->with('success', 'Wilayah diperbarui.');
    }

    public function destroy(Wilayah $wilayah): RedirectResponse
    {
        try {
            $wilayah->delete();

            return back()->with('success', 'Wilayah berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Wilayah tidak dapat dihapus karena masih memiliki data terkait.');
        }
    }
}
