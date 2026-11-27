@php $isEdit = isset($kategori); @endphp

<div class="space-y-5">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-input label="Nama Kategori" name="nama" :value="$kategori->nama ?? null" placeholder="Contoh: Jalan & Jembatan" required />
        <x-input label="Nama Ikon Lucide (Opsional)" name="ikon" :value="$kategori->ikon ?? null" placeholder="Contoh: alert-triangle" helper="Gunakan nama ikon dari lucide.dev." />
    </div>

    <x-textarea label="Deskripsi" name="deskripsi" rows="3" :value="$kategori->deskripsi ?? null" placeholder="Penjelasan singkat jenis laporan untuk kategori ini..." />

    @if ($isEdit)
        <div class="pt-2">
            <input type="hidden" name="aktif" value="0">
            <label class="inline-flex items-center gap-2.5 text-sm text-[#1F2937] cursor-pointer">
                <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $kategori->aktif)) class="rounded border-[#D1D5DB] text-[#1B5E3B] focus:ring-[#1B5E3B]/30">
                <span>Kategori aktif digunakan pada formulir laporan</span>
            </label>
        </div>
    @endif
</div>
