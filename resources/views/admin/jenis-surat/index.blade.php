@extends('layouts.admin')

@section('title', 'Jenis Surat — Admin SIGAP')
@section('page-title', 'Jenis Surat Digital')
@section('page-subtitle', 'Master layanan surat menyurat desa beserta persyaratan dan template PDF')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6" data-gsap="fade-up">
        <p class="text-sm text-[#6B7280]">Total {{ $jenis->count() }} jenis surat tersedia.</p>
        <x-button :href="route('admin.jenis-surat.create')" :navigate="true" variant="primary" size="md" icon="plus">
            Tambah Jenis Surat
        </x-button>
    </div>

    <x-card :flush="true" data-gsap="fade-up">
        @if ($jenis->isEmpty())
            <x-empty-state icon="file-text" title="Belum ada jenis surat" description="Tambahkan jenis layanan surat seperti Domisili, Usaha, atau Pengantar SKCK." />
        @else
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs font-semibold text-[#6B7280] uppercase tracking-wider">
                            <th class="px-6 py-3.5">Nama Layanan Surat</th>
                            <th class="px-6 py-3.5">Persyaratan</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB] text-sm">
                        @foreach ($jenis as $item)
                            <tr class="hover:bg-[#F8FAF7]/60">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-[#1F2937]">{{ $item->nama }}</div>
                                    <div class="text-xs font-mono text-[#9CA3AF]">{{ $item->slug }}</div>
                                </td>
                                <td class="px-6 py-4 text-xs text-[#6B7280]">
                                    {{ count($item->persyaratan ?? []) }} syarat
                                </td>
                                <td class="px-6 py-4">
                                    <x-badge :tone="$item->aktif ? 'success' : 'neutral'">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</x-badge>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <x-button :href="route('admin.jenis-surat.edit', $item)" :navigate="true" variant="outline" size="sm" icon="pencil">Edit</x-button>
                                        <form method="POST" action="{{ route('admin.jenis-surat.destroy', $item) }}" onsubmit="return confirm('Hapus jenis surat ini?')">
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
                @foreach ($jenis as $item)
                    <div class="p-4 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-medium text-sm text-[#1F2937]">{{ $item->nama }}</span>
                            <x-badge :tone="$item->aktif ? 'success' : 'neutral'">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</x-badge>
                        </div>
                        <p class="text-xs text-[#6B7280]">{{ count($item->persyaratan ?? []) }} syarat</p>
                        <div class="flex items-center gap-2 pt-1">
                            <x-button :href="route('admin.jenis-surat.edit', $item)" :navigate="true" variant="outline" size="sm" class="flex-1">Edit</x-button>
                            <form method="POST" action="{{ route('admin.jenis-surat.destroy', $item) }}" onsubmit="return confirm('Hapus jenis surat ini?')">
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
