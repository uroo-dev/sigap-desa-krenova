@php
    $isEdit = isset($berita);
    $currentTipe = old('tipe', $isEdit ? $berita->tipe : 'berita');
    $publishedValue = old('published_at', ($isEdit && $berita->published_at) ? $berita->published_at->format('Y-m-d\TH:i') : '');
@endphp

<div class="space-y-5">
    <x-input label="Judul Konten" name="judul" :value="$berita->judul ?? null" placeholder="Judul berita, pengumuman, atau agenda desa" required />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-select label="Jenis Konten" name="tipe" required>
            @foreach (['berita' => 'Berita', 'pengumuman' => 'Pengumuman', 'agenda' => 'Agenda'] as $val => $label)
                <option value="{{ $val }}" @selected($currentTipe === $val)>{{ $label }}</option>
            @endforeach
        </x-select>

        <x-input
            label="Waktu Publikasi (Opsional)"
            name="published_at"
            type="datetime-local"
            :value="$publishedValue"
            helper="Kosongkan untuk menyimpan sebagai draf."
        />
    </div>

    <x-textarea label="Ringkasan (Opsional)" name="ringkasan" rows="2" :value="$berita->ringkasan ?? null" placeholder="Ringkasan singkat yang tampil di halaman daftar..." />

    <x-textarea label="Isi Lengkap" name="isi" rows="8" :value="$berita->isi ?? null" placeholder="Tulis isi informasi desa secara lengkap dan jelas..." required />
</div>
