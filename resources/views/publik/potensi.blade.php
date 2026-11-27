@extends('layouts.app')

@section('title', 'Potensi Desa — SIGAP')

@section('content')
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8" data-gsap="fade-up">
            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-[#1F2937]">Potensi & Fasilitas Desa</h1>
            <p class="text-sm text-[#6B7280] mt-1">Direktori potensi wisata, pelaku UMKM lokal, dan fasilitas umum desa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-gsap="fade-up">
            <x-card title="Wisata & Destinasi" subtitle="{{ count($wisata) }} lokasi">
                @if (empty($wisata))
                    <x-empty-state icon="mountain" title="Belum ada data wisata" description="Data destinasi wisata desa akan ditampilkan di sini." />
                @endif
            </x-card>

            <x-card title="UMKM Lokal" subtitle="{{ count($umkm) }} usaha">
                @if (empty($umkm))
                    <x-empty-state icon="store" title="Belum ada data UMKM" description="Produk unggulan dan usaha warga akan ditampilkan di sini." />
                @endif
            </x-card>

            <x-card title="Fasilitas Umum" subtitle="{{ count($fasilitas) }} fasilitas">
                @if (empty($fasilitas))
                    <x-empty-state icon="building-2" title="Belum ada data fasilitas" description="Sekolah, balai desa, dan fasilitas kesehatan akan tampil di sini." />
                @endif
            </x-card>
        </div>
    </div>
@endsection
