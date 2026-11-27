@extends('layouts.admin')

@section('title', 'Berita & Konten — Admin SIGAP')
@section('page-title', 'Berita & Konten Publik')
@section('page-subtitle', 'Kelola berita desa, pengumuman warga, dan agenda kegiatan')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6" data-gsap="fade-up">
        <p class="text-sm text-[#6B7280]">Total {{ $berita->total() }} konten tersimpan.</p>
        <x-button :href="route('admin.berita.create')" :navigate="true" variant="primary" size="md" icon="plus">
            Buat Konten
        </x-button>
    </div>

    <x-card :flush="true" data-gsap="fade-up">
        @if ($berita->isEmpty())
            <x-empty-state icon="newspaper" title="Belum ada berita atau pengumuman" description="Mulai publikasikan kabar dan agenda desa agar masyarakat selalu terinformasi." />
        @else
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAF7] border-b border-[#E5E7EB] text-xs font-semibold text-[#6B7280] uppercase tracking-wider">
                            <th class="px-6 py-3.5">Judul</th>
                            <th class="px-6 py-3.5">Tipe</th>
                            <th class="px-6 py-3.5">Status Publikasi</th>
                            <th class="px-6 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E5E7EB] text-sm">
                        @foreach ($berita as $item)
                            <tr class="hover:bg-[#F8FAF7]/60">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-[#1F2937]">{{ $item->judul }}</div>
                                    <div class="text-xs font-mono text-[#9CA3AF]">{{ $item->slug }}</div>
                                </td>
                                <td class="px-6 py-4"><x-badge tone="primary">{{ ucfirst($item->tipe) }}</x-badge></td>
                                <td class="px-6 py-4">
                                    @if ($item->published_at)
                                        <x-badge tone="success">{{ $item->published_at->format('d M Y H:i') }}</x-badge>
                                    @else
                                        <x-badge tone="neutral">Draf</x-badge>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <x-button :href="route('admin.berita.edit', $item)" :navigate="true" variant="outline" size="sm" icon="pencil">Edit</x-button>
                                        <form method="POST" action="{{ route('admin.berita.destroy', $item) }}" onsubmit="return confirm('Hapus konten ini?')">
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
                @foreach ($berita as $item)
                    <div class="p-4 space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-medium text-sm text-[#1F2937]">{{ $item->judul }}</span>
                            <x-badge tone="primary">{{ ucfirst($item->tipe) }}</x-badge>
                        </div>
                        <p class="text-xs text-[#6B7280]">{{ $item->published_at ? 'Terbit '.$item->published_at->format('d M Y') : 'Draf' }}</p>
                        <div class="flex items-center gap-2 pt-1">
                            <x-button :href="route('admin.berita.edit', $item)" :navigate="true" variant="outline" size="sm" class="flex-1">Edit</x-button>
                            <form method="POST" action="{{ route('admin.berita.destroy', $item) }}" onsubmit="return confirm('Hapus konten ini?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="ghost" size="sm" class="text-[#DC2626]">Hapus</x-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($berita->hasPages())
                <div class="px-6 py-4 border-t border-[#E5E7EB]">
                    {{ $berita->links() }}
                </div>
            @endif
        @endif
    </x-card>
@endsection
