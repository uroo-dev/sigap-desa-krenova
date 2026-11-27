@php
    $isEdit = isset($jenis);
    $persyaratanList = array_values(array_filter(old('persyaratan', $isEdit ? ($jenis->persyaratan ?? []) : ['Fotokopi KTP', 'Fotokopi KK'])));
@endphp

<div class="space-y-5">
    <x-input label="Nama Jenis Surat" name="nama" :value="$jenis->nama ?? null" placeholder="Contoh: Surat Keterangan Domisili" required />

    <x-textarea label="Deskripsi" name="deskripsi" rows="2" :value="$jenis->deskripsi ?? null" placeholder="Keterangan kegunaan surat ini bagi warga..." />

    {{-- Daftar Persyaratan Dinamis --}}
    <div x-data="{ items: @js(count($persyaratanList) ? $persyaratanList : ['']) }">
        <div class="flex items-center justify-between mb-2">
            <label class="block text-sm font-medium text-[#1F2937]">Daftar Persyaratan</label>
            <button
                type="button"
                @click="items.push('')"
                class="text-xs font-medium text-[#1B5E3B] hover:text-[#15452D] inline-flex items-center gap-1"
            >
                <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                Tambah Syarat
            </button>
        </div>

        <div class="space-y-2">
            <template x-for="(item, idx) in items" :key="idx">
                <div class="flex items-center gap-2">
                    <input
                        type="text"
                        name="persyaratan[]"
                        x-model="items[idx]"
                        placeholder="Contoh: Fotokopi KTP"
                        class="flex-1 h-10 px-3.5 rounded-lg border border-[#D1D5DB] bg-white text-sm text-[#1F2937] focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B]"
                    >
                    <button
                        type="button"
                        @click="items.length > 1 ? items.splice(idx, 1) : items[0] = ''"
                        class="h-10 px-3 rounded-lg border border-[#E5E7EB] text-[#6B7280] hover:text-[#DC2626] hover:bg-red-50"
                        title="Hapus baris"
                    >
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </div>
            </template>
        </div>
    </div>

    <x-textarea
        label="Template Isi Surat (Opsional)"
        name="template_isi"
        rows="6"
        :value="$jenis->template_isi ?? null"
        placeholder="Template paragraf isi surat untuk generate PDF..."
    />

    @if ($isEdit)
        <div class="pt-2">
            <input type="hidden" name="aktif" value="0">
            <label class="inline-flex items-center gap-2.5 text-sm text-[#1F2937] cursor-pointer">
                <input type="checkbox" name="aktif" value="1" @checked(old('aktif', $jenis->aktif)) class="rounded border-[#D1D5DB] text-[#1B5E3B] focus:ring-[#1B5E3B]/30">
                <span>Jenis surat aktif dibuka untuk pengajuan warga</span>
            </label>
        </div>
    @endif
</div>
