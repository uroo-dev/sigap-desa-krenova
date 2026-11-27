@extends('layouts.app')

@section('title', 'Informasi & Berita Desa — SIGAP')

@section('content')
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8" data-gsap="fade-up">
            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-[#1F2937]">Informasi Desa</h1>
            <p class="text-sm text-[#6B7280] mt-1">Berita resmi, pengumuman warga, dan agenda kegiatan pemerintah desa.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Daftar Berita --}}
            <div class="lg:col-span-8 space-y-4" data-gsap="fade-up">
                @if ($berita->isEmpty())
                    <x-card>
                        <x-empty-state icon="newspaper" title="Belum ada berita terbit" description="Berita resmi desa yang dipublikasikan akan tampil di daftar ini." />
                    </x-card>
                @else
                    @foreach ($berita as $item)
                        <x-card>
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                <x-badge tone="primary">Berita</x-badge>
                                <span class="text-xs text-[#9CA3AF]">{{ $item->published_at?->translatedFormat('d M Y') }}</span>
                            </div>
                            <h2 class="font-heading text-lg font-semibold text-[#1F2937]">
                                <a href="{{ route('publik.informasi.detail', $item->slug) }}" class="hover:text-[#1B5E3B]">
                                    {{ $item->judul }}
                                </a>
                            </h2>
                            <p class="text-sm text-[#6B7280] mt-2 leading-relaxed">
                                {{ $item->ringkasan ?: \Illuminate\Support\Str::limit(strip_tags($item->isi), 160) }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('publik.informasi.detail', $item->slug) }}" class="text-sm font-medium text-[#1B5E3B] hover:text-[#15452D] inline-flex items-center gap-1.5">
                                    <span>Baca selengkapnya</span>
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </x-card>
                    @endforeach

                    <div class="pt-2">{{ $berita->links() }}</div>
                @endif
            </div>

            {{-- Sidebar Pengumuman & Agenda --}}
            <div class="lg:col-span-4 space-y-6" data-gsap="fade-up">
                <x-card title="Pengumuman" subtitle="Informasi penting desa">
                    @if ($pengumuman->isEmpty())
                        <p class="text-xs text-[#6B7280]">Belum ada pengumuman aktif.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach ($pengumuman as $p)
                                <li class="pb-3 border-b border-[#E5E7EB] last:border-0 last:pb-0">
                                    <a href="{{ route('publik.informasi.detail', $p->slug) }}" class="block text-sm font-medium text-[#1F2937] hover:text-[#1B5E3B]">
                                        {{ $p->judul }}
                                    </a>
                                    <span class="text-xs text-[#9CA3AF]">{{ $p->published_at?->translatedFormat('d M Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </x-card>

                <x-card title="Agenda Kegiatan" subtitle="Jadwal kegiatan mendatang">
                    @if ($agenda->isEmpty())
                        <p class="text-xs text-[#6B7280]">Belum ada agenda terjadwal.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach ($agenda as $a)
                                <li class="pb-3 border-b border-[#E5E7EB] last:border-0 last:pb-0">
                                    <a href="{{ route('publik.informasi.detail', $a->slug) }}" class="block text-sm font-medium text-[#1F2937] hover:text-[#1B5E3B]">
                                        {{ $a->judul }}
                                    </a>
                                    <span class="text-xs text-[#9CA3AF]">{{ $a->published_at?->translatedFormat('d M Y') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </x-card>
            </div>
        </div>
    </div>
@endsection
