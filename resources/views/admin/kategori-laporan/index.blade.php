@extends('layouts.admin')

@section('title', 'Kategori Laporan — Admin SIGAP')
@section('page-title', 'Kategori Laporan')
@section('page-subtitle', 'Master kategori pengaduan dan aspirasi masyarakat')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6" data-gsap="fade-up">
        <p class="text-sm text-[#6B7280]">Total {{ $kategori->count() }} kategori tersedia.</p>
        <x-button :href="route('admin.kategori-laporan.create')" :navigate="true" variant="primary" size="md" icon="plus">
            Tambah Kategori
        </x-button>
    </div>

    <x-card :flush="true" data-gsap="fade-up">
        @if ($kategori->isEmpty())
            <x-empty-state icon="clipboard-list" title="Belum ada kategori laporan" description="Tambahkan kategori seperti Jalan Rusak, Drainase, Lampu Jalan, atau Kebersihan." />
        @else
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs font-semibold text-[#6B7280] uppercase tracking-wider">
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Slug</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB] text-sm">
                        @foreach ($kategori as $item)
                            <tr class="hover:bg-[#F8FAF7]/60">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-[#1F2937]">{{ $item->nama }}</div>
                                    @if ($item->deskripsi)
                                        <div class="text-xs text-[#6B7280] mt-0.5">{{ $item->deskripsi }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-mono text-xs text-[#6B7280]">{{ $item->slug }}</td>
                                <td class="px-6 py-4">
                                    <x-badge :tone="$item->aktif ? 'success' : 'neutral'">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</x-badge>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <x-button :href="route('admin.kategori-laporan.edit', $item)" :navigate="true" variant="outline" size="sm" icon="pencil">Edit</x-button>
                                        <form method="POST" action="{{ route('admin.kategori-laporan.destroy', $item) }}" onsubmit="return confirm('Hapus kategori ini?')">
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
                @foreach ($kategori as $item)
                    <div class="p-4 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-medium text-sm text-[#1F2937]">{{ $item->nama }}</span>
                            <x-badge :tone="$item->aktif ? 'success' : 'neutral'">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</x-badge>
                        </div>
                        <p class="text-xs text-[#6B7280]">{{ $item->deskripsi ?: $item->slug }}</p>
                        <div class="flex items-center gap-2 pt-1">
                            <x-button :href="route('admin.kategori-laporan.edit', $item)" :navigate="true" variant="outline" size="sm" class="flex-1">Edit</x-button>
                            <form method="POST" action="{{ route('admin.kategori-laporan.destroy', $item) }}" onsubmit="return confirm('Hapus kategori ini?')">
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
