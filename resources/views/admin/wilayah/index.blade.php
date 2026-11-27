@extends('layouts.admin')

@section('title', 'Wilayah & GIS — Admin SIGAP')
@section('page-title', 'Wilayah & GIS')
@section('page-subtitle', 'Kelola hierarki Desa, Dusun, RW, RT beserta batas poligon GeoJSON')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6" data-gsap="fade-up">
        <p class="text-sm text-[#6B7280]">Total {{ $wilayah->count() }} wilayah terdaftar.</p>
        <x-button :href="route('admin.wilayah.create')" :navigate="true" variant="primary" size="md" icon="plus">
            Tambah Wilayah
        </x-button>
    </div>

    <x-card :flush="true" data-gsap="fade-up">
        @if ($wilayah->isEmpty())
            <x-empty-state icon="map-pin" title="Belum ada data wilayah" description="Tambahkan data Desa, Dusun, RW, atau RT untuk mengaktifkan pemetaan GIS." />
        @else
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs font-semibold text-[#6B7280] uppercase tracking-wider">
                            <th class="px-6 py-3.5">Nama Wilayah</th>
                            <th class="px-6 py-3.5">Tingkat</th>
                            <th class="px-6 py-3.5">Induk</th>
                            <th class="px-6 py-3.5">Kode</th>
                            <th class="px-6 py-3.5">GeoJSON</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB] text-sm">
                        @foreach ($wilayah as $item)
                            <tr class="hover:bg-[#F8FAF7]/60">
                                <td class="px-6 py-4 font-medium text-[#1F2937]">{{ $item->nama }}</td>
                                <td class="px-6 py-4"><x-badge tone="primary">{{ strtoupper($item->tipe) }}</x-badge></td>
                                <td class="px-6 py-4 text-[#6B7280]">{{ $item->parent?->nama ?? '-' }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-[#6B7280]">{{ $item->kode ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <x-badge :tone="$item->geojson ? 'success' : 'neutral'">
                                        {{ $item->geojson ? 'Tersedia' : 'Kosong' }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <x-button :href="route('admin.wilayah.edit', $item)" :navigate="true" variant="outline" size="sm" icon="pencil">Edit</x-button>
                                        <form method="POST" action="{{ route('admin.wilayah.destroy', $item) }}" onsubmit="return confirm('Hapus wilayah ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" variant="ghost" size="sm" class="text-[#DC2626] hover:bg-red-50">Hapus</x-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-[#E5E7EB]">
                @foreach ($wilayah as $item)
                    <div class="p-4 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-medium text-sm text-[#1F2937]">{{ $item->nama }}</span>
                            <x-badge tone="primary">{{ strtoupper($item->tipe) }}</x-badge>
                        </div>
                        <p class="text-xs text-[#6B7280]">Induk: {{ $item->parent?->nama ?? '-' }} · Kode: {{ $item->kode ?? '-' }}</p>
                        <div class="flex items-center gap-2 pt-1">
                            <x-button :href="route('admin.wilayah.edit', $item)" :navigate="true" variant="outline" size="sm" class="flex-1">Edit</x-button>
                            <form method="POST" action="{{ route('admin.wilayah.destroy', $item) }}" onsubmit="return confirm('Hapus wilayah ini?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="ghost" size="sm" class="text-[#DC2626]">Hapus</x-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </x-card>
@endsection
