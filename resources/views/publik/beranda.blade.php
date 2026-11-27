@extends('layouts.app')

@section('title', 'SIGAP — Desa Terhubung, Masyarakat Terlayani')

@section('content')
    {{-- Hero Section (Minimalist Civic Green) --}}
    <section class="bg-white border-b border-[#E5E7EB]">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7 space-y-5" data-gsap="fade-up">
                    <x-badge tone="primary">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                        <span>{{ $desa?->nama ?? config('sigap.identitas.nama_desa', 'Sistem Informasi Desa') }}</span>
                    </x-badge>

                    <h1 class="font-heading text-3xl sm:text-4xl lg:text-[48px] font-bold text-[#1F2937] leading-[1.15] tracking-tight">
                        Desa Terhubung,<br>
                        <span class="text-[#1B5E3B]">Masyarakat Terlayani.</span>
                    </h1>

                    <p class="text-base text-[#6B7280] leading-relaxed max-w-2xl">
                        Platform terintegrasi untuk menyampaikan aspirasi berbasis peta wilayah (GIS), mengelola data kependudukan desa, dan mengajukan pelayanan surat administrasi secara transparan.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <x-button :href="route('publik.peta')" variant="primary" size="lg" icon="map">
                            Jelajahi Peta Desa
                        </x-button>
                        <x-button :href="route('publik.laporan')" variant="outline" size="lg" icon="clipboard-list">
                            Pantau Laporan Publik
                        </x-button>
                    </div>
                </div>

                {{-- Ringkasan Statistik Desa --}}
                <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 gap-4" data-gsap="fade-up">
                    <div class="bg-[#F8FAF7] border border-[#E5E7EB] rounded-xl p-5">
                        <div class="w-10 h-10 rounded-lg bg-[#E7F1E9] text-[#1B5E3B] flex items-center justify-center mb-3">
                            <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                        </div>
                        <p class="text-xs font-medium text-[#6B7280]">Total Aspirasi Warga</p>
                        <p class="font-heading text-3xl font-bold text-[#1F2937] mt-1">{{ number_format($totalLaporan) }}</p>
                    </div>

                    <div class="bg-[#F8FAF7] border border-[#E5E7EB] rounded-xl p-5">
                        <div class="w-10 h-10 rounded-lg bg-green-100 text-[#16A34A] flex items-center justify-center mb-3">
                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                        </div>
                        <p class="text-xs font-medium text-[#6B7280]">Laporan Tuntas Divalidasi</p>
                        <p class="font-heading text-3xl font-bold text-[#1F2937] mt-1">{{ number_format($laporanSelesai) }}</p>
                    </div>

                    <div class="sm:col-span-2 bg-[#E7F1E9]/60 border border-[#1B5E3B]/15 rounded-xl p-5 flex items-center justify-between gap-4">
                        <div>
                            <h3 class="font-heading text-sm font-semibold text-[#1B5E3B]">Layanan Warga & Surat Digital</h3>
                            <p class="text-xs text-[#6B7280] mt-0.5">Masuk dengan akun warga atau Google untuk membuat laporan dan mengajukan surat.</p>
                        </div>
                        <x-button :href="route('login')" variant="primary" size="sm" icon="arrow-right">
                            Masuk
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Tiga Modul Utama SIGAP --}}
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-12" data-gsap="reveal">
        <div class="mb-6">
            <h2 class="font-heading text-2xl font-bold text-[#1F2937]">Tiga Layanan Inti Desa</h2>
            <p class="text-sm text-[#6B7280] mt-1">Dirancang ringkas, cepat, dan mudah digunakan oleh masyarakat maupun perangkat desa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-card>
                <div class="w-10 h-10 rounded-lg bg-[#E7F1E9] text-[#1B5E3B] flex items-center justify-center mb-4">
                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                </div>
                <h3 class="font-heading text-lg font-semibold text-[#1F2937]">Pelaporan Masalah GIS</h3>
                <p class="text-sm text-[#6B7280] mt-2 leading-relaxed">
                    Laporkan kerusakan jalan, drainase, atau fasilitas umum langsung dari titik koordinat peta, diverifikasi RT hingga validasi Kepala Desa.
                </p>
            </x-card>

            <x-card>
                <div class="w-10 h-10 rounded-lg bg-[#EDF5D8] text-[#1B5E3B] flex items-center justify-center mb-4">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
                <h3 class="font-heading text-lg font-semibold text-[#1F2937]">Manajemen Masyarakat</h3>
                <p class="text-sm text-[#6B7280] mt-2 leading-relaxed">
                    Pendataan penduduk dan kartu keluarga berbasis wilayah RT/RW dengan perlindungan enkripsi data pribadi NIK dan nomor KK.
                </p>
            </x-card>

            <x-card>
                <div class="w-10 h-10 rounded-lg bg-[#E7F1E9] text-[#1B5E3B] flex items-center justify-center mb-4">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
                <h3 class="font-heading text-lg font-semibold text-[#1F2937]">Pelayanan Surat Digital</h3>
                <p class="text-sm text-[#6B7280] mt-2 leading-relaxed">
                    Ajukan surat keterangan secara daring dengan persetujuan berjenjang RT dan Kepala Desa serta unduh dokumen PDF siap cetak.
                </p>
            </x-card>
        </div>
    </section>

    {{-- Berita & Informasi Desa Terbaru --}}
    <section class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pb-12" data-gsap="reveal">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="font-heading text-2xl font-bold text-[#1F2937]">Informasi & Agenda Desa</h2>
                <p class="text-sm text-[#6B7280] mt-1">Kabar terbaru, pengumuman resmi, dan jadwal kegiatan desa.</p>
            </div>
            <x-button :href="route('publik.informasi')" variant="outline" size="sm" icon="arrow-right">
                Lihat Semua
            </x-button>
        </div>

        @if ($beritaTerbaru->isEmpty())
            <x-card>
                <x-empty-state
                    icon="newspaper"
                    title="Belum ada informasi dipublikasikan"
                    description="Berita, pengumuman, dan agenda desa akan muncul di halaman ini."
                />
            </x-card>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($beritaTerbaru as $item)
                    <x-card class="flex flex-col justify-between h-full">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <x-badge tone="primary">{{ ucfirst($item->tipe) }}</x-badge>
                                <span class="text-xs text-[#9CA3AF]">{{ $item->published_at?->translatedFormat('d M Y') }}</span>
                            </div>
                            <h3 class="font-heading text-base font-semibold text-[#1F2937] line-clamp-2">
                                <a href="{{ route('publik.informasi.detail', $item->slug) }}" class="hover:text-[#1B5E3B]">
                                    {{ $item->judul }}
                                </a>
                            </h3>
                            <p class="text-sm text-[#6B7280] mt-2 line-clamp-3">
                                {{ $item->ringkasan ?: \Illuminate\Support\Str::limit(strip_tags($item->isi), 120) }}
                            </p>
                        </div>
                        <div class="mt-4 pt-3 border-t border-[#E5E7EB]">
                            <a href="{{ route('publik.informasi.detail', $item->slug) }}" class="text-sm font-medium text-[#1B5E3B] hover:text-[#15452D] inline-flex items-center gap-1.5">
                                <span>Baca selengkapnya</span>
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @endif
    </section>
@endsection
