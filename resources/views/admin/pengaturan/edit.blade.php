@extends('layouts.admin')

@section('title', 'Pengaturan Desa — Admin SIGAP')
@section('page-title', 'Pengaturan Desa')
@section('page-subtitle', 'Identitas resmi pemerintah desa untuk portal publik dan kop surat digital')

@section('content')
    <div class="max-w-3xl" data-gsap="fade-up">
        <x-card title="Identitas & Kontak Desa">
            <form method="POST" action="{{ route('admin.pengaturan.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <x-input label="Nama Desa" name="nama_desa" :value="$pengaturan['nama_desa'] ?? ''" required />
                    <x-input label="Kecamatan" name="kecamatan" :value="$pengaturan['kecamatan'] ?? ''" />
                    <x-input label="Kabupaten / Kota" name="kabupaten" :value="$pengaturan['kabupaten'] ?? ''" />
                    <x-input label="Provinsi" name="provinsi" :value="$pengaturan['provinsi'] ?? ''" />
                    <x-input label="Kode Pos" name="kode_pos" :value="$pengaturan['kode_pos'] ?? ''" />
                    <x-input label="Email Resmi Desa" name="email_desa" type="email" :value="$pengaturan['email_desa'] ?? ''" />
                    <x-input label="Telepon Kantor Desa" name="telepon_desa" :value="$pengaturan['telepon_desa'] ?? ''" />
                </div>

                <x-textarea label="Alamat Lengkap Kantor Desa" name="alamat_kantor" rows="2" :value="$pengaturan['alamat_kantor'] ?? ''" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label for="logo" class="block text-sm font-medium text-[#1F2937] mb-1.5">Logo Desa (Opsional)</label>
                        <input id="logo" type="file" name="logo" accept="image/*" class="block w-full text-xs text-[#6B7280] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border file:border-[#D1D5DB] file:text-xs file:font-medium file:bg-[#F8FAF7] file:text-[#1F2937] hover:file:bg-[#E7F1E9]">
                    </div>
                    <div>
                        <label for="kop_surat" class="block text-sm font-medium text-[#1F2937] mb-1.5">Kop Surat Resmi (Opsional)</label>
                        <input id="kop_surat" type="file" name="kop_surat" accept="image/*" class="block w-full text-xs text-[#6B7280] file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border file:border-[#D1D5DB] file:text-xs file:font-medium file:bg-[#F8FAF7] file:text-[#1F2937] hover:file:bg-[#E7F1E9]">
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-[#E5E7EB]">
                    <x-button type="submit" variant="primary" size="md" icon="save">
                        Simpan Perubahan
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
