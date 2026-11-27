@php
    $isEdit = isset($wilayah);
    $currentTipe = old('tipe', $isEdit ? $wilayah->tipe : 'rt');
    $currentParent = old('parent_id', $isEdit ? $wilayah->parent_id : '');
    $geojsonText = old('geojson', ($isEdit && $wilayah->geojson) ? json_encode($wilayah->geojson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '');
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <x-select label="Tingkat Wilayah" name="tipe" required>
        @foreach (['desa' => 'Desa', 'dusun' => 'Dusun', 'rw' => 'RW', 'rt' => 'RT'] as $val => $label)
            <option value="{{ $val }}" @selected($currentTipe === $val)>{{ $label }}</option>
        @endforeach
    </x-select>

    <x-select label="Wilayah Induk (Opsional)" name="parent_id">
        <option value="">Tanpa Induk (Tingkat Desa)</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @selected((string) $currentParent === (string) $parent->id)>
                [{{ strtoupper($parent->tipe) }}] {{ $parent->nama }}
            </option>
        @endforeach
    </x-select>

    <x-input label="Nama Wilayah" name="nama" :value="$wilayah->nama ?? null" placeholder="Contoh: RT 01" required />
    <x-input label="Kode Wilayah (Opsional)" name="kode" :value="$wilayah->kode ?? null" placeholder="Contoh: RT-01" />
</div>

<div class="mt-5">
    <x-textarea
        label="Data Poligon GeoJSON (Opsional)"
        name="geojson"
        rows="6"
        :value="$geojsonText"
        placeholder='{"type":"Polygon","coordinates":[...]}'
        helper="Salin format GeoJSON dari geojson.io untuk pemetaan batas wilayah di peta GIS."
        class="font-mono text-xs"
    />
</div>
