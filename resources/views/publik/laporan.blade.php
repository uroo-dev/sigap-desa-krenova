@extends('layouts.app')

@section('title', 'Laporan Publik — SIGAP')

@section('content')
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6" data-gsap="fade-up">
            <div>
                <h1 class="font-heading text-2xl sm:text-3xl font-bold text-[#1F2937]">Transparansi Laporan Publik</h1>
                <p class="text-sm text-[#6B7280] mt-1">Pantau progres penanganan aspirasi warga secara terbuka dengan identitas pelapor yang disamarkan.</p>
            </div>

            <x-button :href="route('login')" variant="primary" size="md" icon="plus">
                Buat Laporan
            </x-button>
        </div>

        @if ($laporan->isEmpty())
            <x-card data-gsap="fade-up">
                <x-empty-state
                    icon="clipboard-list"
                    title="Belum ada laporan terverifikasi"
                    description="Laporan masyarakat yang telah diverifikasi RT akan ditampilkan di sini untuk transparansi publik."
                />
            </x-card>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-gsap="fade-up">
                @foreach ($laporan as $item)
                    <x-card class="flex flex-col justify-between h-full">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-xs font-mono text-[#6B7280]">{{ $item->nomor_laporan }}</span>
                                <x-badge :status="$item->status" />
                            </div>

                            <h2 class="font-heading text-base font-semibold text-[#1F2937]">
                                <a href="{{ route('publik.laporan.detail', $item) }}" class="hover:text-[#1B5E3B]">
                                    {{ $item->judul }}
                                </a>
                            </h2>

                            <p class="text-sm text-[#6B7280] mt-2 line-clamp-3">
                                {{ $item->deskripsi }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-[#E5E7EB] flex items-center justify-between text-xs text-[#6B7280]">
                            <span class="inline-flex items-center gap-1">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#1B5E3B]"></i>
                                {{ $item->rt?->nama ?? '-' }} · {{ $item->kategori?->nama ?? '-' }}
                            </span>
                            <a href="{{ route('publik.laporan.detail', $item) }}" class="font-medium text-[#1B5E3B] hover:text-[#15452D]">
                                Detail →
                            </a>
                        </div>
                    </x-card>
                @endforeach
            </div>

            <div class="mt-6">{{ $laporan->links() }}</div>
        @endif
    </div>
@endsection
