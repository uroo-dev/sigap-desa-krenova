@extends('layouts.app')

@section('title', 'Peta Wilayah Desa — SIGAP')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
@endpush

@section('content')
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6" data-gsap="fade-up">
            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-[#1F2937]">Peta Wilayah & Batas RT</h1>
            <p class="text-sm text-[#6B7280] mt-1">
                Visualisasi spasial wilayah {{ $desa?->nama ?? 'desa' }} berbasis OpenStreetMap & GeoJSON.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Map-First Canvas --}}
            <div class="lg:col-span-8" data-gsap="fade-up">
                <x-card :flush="true">
                    <div id="sigap-public-map" class="w-full h-[460px] lg:h-[580px] bg-[#F8FAF7]"></div>
                </x-card>
            </div>

            {{-- Daftar Wilayah RT --}}
            <div class="lg:col-span-4" data-gsap="fade-up">
                <x-card title="Daftar Wilayah RT" subtitle="{{ $rt->count() }} wilayah RT terdaftar">
                    @if ($rt->isEmpty())
                        <x-empty-state
                            icon="map-pin"
                            title="Data RT belum tersedia"
                            description="Admin dapat menambahkan wilayah dan data GeoJSON melalui panel Admin."
                        />
                    @else
                        <div class="space-y-2 max-h-[480px] overflow-y-auto pr-1">
                            @foreach ($rt as $item)
                                <button
                                    type="button"
                                    onclick="window.focusSigapRt && window.focusSigapRt({{ $item->id }})"
                                    class="w-full text-left p-3 rounded-lg border border-[#E5E7EB] hover:border-[#1B5E3B]/40 hover:bg-[#F8FAF7] transition-colors flex items-center justify-between gap-3"
                                >
                                    <div>
                                        <p class="font-heading text-sm font-semibold text-[#1F2937]">{{ $item->nama }}</p>
                                        <p class="text-xs text-[#6B7280]">
                                            {{ $item->parent?->nama ?? 'Induk belum diatur' }}
                                            @if ($item->kode) · Kode {{ $item->kode }} @endif
                                        </p>
                                    </div>
                                    <x-badge :tone="$item->geojson ? 'success' : 'neutral'">
                                        {{ $item->geojson ? 'GeoJSON' : 'Tanpa Peta' }}
                                    </x-badge>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </x-card>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('sigap-public-map');
            if (!container || typeof L === 'undefined') return;

            const map = L.map(container).setView([-7.150975, 110.140259], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const rtData = @json($rt);
            const layersById = {};
            const group = L.featureGroup().addTo(map);

            rtData.forEach((item) => {
                if (!item.geojson) return;
                try {
                    const layer = L.geoJSON(item.geojson, {
                        style: {
                            color: '#1B5E3B',
                            weight: 2,
                            fillColor: '#A7C957',
                            fillOpacity: 0.28,
                        }
                    }).bindPopup(`<strong>${item.nama}</strong>`);
                    layer.addTo(group);
                    layersById[item.id] = layer;
                } catch (e) {
                    // Abaikan GeoJSON tidak valid agar peta tetap tampil
                }
            });

            if (group.getLayers().length > 0) {
                map.fitBounds(group.getBounds(), { padding: [24, 24] });
            }

            window.focusSigapRt = (id) => {
                const target = layersById[id];
                if (target) {
                    map.fitBounds(target.getBounds(), { padding: [32, 32] });
                    target.openPopup();
                }
            };
        });
    </script>
@endpush
