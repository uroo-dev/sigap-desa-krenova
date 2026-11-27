<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaturanDesaController extends Controller
{
    public function edit(): View
    {
        return view('admin.pengaturan.edit', [
            'pengaturan' => config('sigap.identitas', []),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_desa' => ['required', 'string', 'max:100'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'kabupaten' => ['nullable', 'string', 'max:100'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kode_pos' => ['nullable', 'string', 'max:10'],
            'email_desa' => ['nullable', 'email'],
            'telepon_desa' => ['nullable', 'string', 'max:20'],
            'alamat_kantor' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'kop_surat' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Penyimpanan persisten ke database/storage akan dilengkapi pada modul Admin Lanjutan
        return back()->with('success', 'Pengaturan desa diperbarui.');
    }
}
