@extends('layouts.app')

@section('title', $laporan->judul.' — Laporan Publik SIGAP')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
@endpush

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6" data-gsap="fade-up">
            <a href="{{ route('publik.laporan') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-[#6B7280] hover:text-[#1B5E3B]">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Daftar Laporan Publik
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-7 space-y-6" data-gsap="fade-up">
                <x-card>
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
                        <span class="text-xs font-mono text-[#6B7280]">{{ $laporan->nomor_laporan }}</span>
                        <x-badge :status="$laporan->status" />
                    </div>

                    <h1 class="font-heading text-2xl font-bold text-[#1F2937]">{{ $laporan->judul }}</h1>

                    <div class="mt-3 flex flex-wrap gap-3 text-xs text-[#6B7280]">
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="tag" class="w-3.5 h-3.5"></i>
                            {{ $laporan->kategori?->nama ?? '-' }}
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                            {{ $laporan->rt?->nama ?? '-' }}
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <i data-lucide="shield-check" class="w-3.5 h-3.5 text-[#1B5E3B]"></i>
                            Pelapor Anonim
                        </span>
                    </div>

                    <div class="mt-5 pt-5 border-t border-[#E5E7EB] text-sm text-[#1F2937] leading-relaxed whitespace-pre-line">
                        {{ $laporan->deskripsi }}
                    </div>

                    @if ($laporan->alamat_lokasi)
                        <div class="mt-4 p-3 rounded-lg bg-[#F8FAF7] border border-[#E5E7EB] text-xs text-[#6B7280]">
                            <strong class="text-[#1F2937]">Lokasi:</strong> {{ $laporan->alamat_lokasi }}
                        </div>
                    @endif
                </x-card>

                @if ($laporan->catatan_rt || $laporan->catatan_kades)
                    <x-card title="Catatan Penanganan">
                        <div class="space-y-3 text-sm">
                            @if ($laporan->catatan_rt)
                                <div class="p-3 rounded-lg bg-[#F8FAF7] border border-[#E5E7EB]">
                                    <p class="text-xs font-semibold text-[#1B5E3B]">Catatan Ketua RT</p>
                                    <p class="text-[#1F2937] mt-1">{{ $laporan->catatan_rt }}</p>
                                </div>
                            @endif
                            @if ($laporan->catatan_kades)
                                <div class="p-3 rounded-lg bg-[#E7F1E9]/50 border border-[#1B5E3B]/20">
                                    <p class="text-xs font-semibold text-[#1B5E3B]">Instruksi / Validasi Kepala Desa</p>
                                    <p class="text-[#1F2937] mt-1">{{ $laporan->catatan_kades }}</p>
                                </div>
                            @endif
                        </div>
                    </x-card>
                @endif
            </div>

            <div class="lg:col-span-5" data-gsap="fade-up">
                <x-card title="Lokasi Kejadian (GIS)" :flush="true">
                    <div id="laporan-detail-map" class="w-full h-[360px] bg-[#F8FAF7]"></div>
                </x-card>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('laporan-detail-map');
            if (!el || typeof L === 'undefined') return;

            const lat = {{ $laporan->latitude }};
            const lng = {{ $laporan->longitude }};
            const map = L.map(el).setView([lat, lng], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            L.marker([lat, lng]).addTo(map).bindPopup(@json($laporan->judul)).openPopup();
        });
    </script>
@endpush
