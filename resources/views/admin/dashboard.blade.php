@extends('layouts.admin')

@section('title', 'Dashboard Admin — SIGAP')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Ringkasan data master, kependudukan, laporan wilayah, dan layanan surat digital')

@section('content')
    {{-- Kartu Statistik Utama --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <x-card data-gsap="fade-up">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-[#6B7280]">Total Pengguna</p>
                    <p class="font-heading text-3xl font-bold text-[#1F2937] mt-1">{{ number_format($totalUser) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-[#E7F1E9] text-[#1B5E3B] flex items-center justify-center">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
        </x-card>

        <x-card data-gsap="fade-up">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-[#6B7280]">Data Warga</p>
                    <p class="font-heading text-3xl font-bold text-[#1F2937] mt-1">{{ number_format($totalWarga) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-[#EDF5D8] text-[#1B5E3B] flex items-center justify-center">
                    <i data-lucide="house" class="w-5 h-5"></i>
                </div>
            </div>
        </x-card>

        <x-card data-gsap="fade-up">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-[#6B7280]">Total Laporan</p>
                    <p class="font-heading text-3xl font-bold text-[#1F2937] mt-1">{{ number_format($totalLaporan) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-[#2563EB] flex items-center justify-center">
                    <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                </div>
            </div>
        </x-card>

        <x-card data-gsap="fade-up">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-xs font-medium text-[#6B7280]">Surat Digital</p>
                    <p class="font-heading text-3xl font-bold text-[#1F2937] mt-1">{{ number_format($totalSurat) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-green-50 text-[#16A34A] flex items-center justify-center">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Pintasan Modul Administrasi (Navigasi Tanpa Reload via wire:navigate) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" data-gsap="fade-up">
        <x-card title="Pengguna & Role" subtitle="Kelola akun warga, Ketua RT, Kepala Desa, dan Admin">
            <p class="text-sm text-[#6B7280] mb-4">Atur hak akses berbasis Spatie Permission serta penugasan wilayah RT.</p>
            <x-button :href="route('admin.users.index')" :navigate="true" variant="secondary" size="sm" icon="arrow-right">
                Kelola Pengguna
            </x-button>
        </x-card>

        <x-card title="Wilayah & GeoJSON" subtitle="Struktur Desa, Dusun, RW, RT, dan batas poligon peta">
            <p class="text-sm text-[#6B7280] mb-4">Konfigurasi hierarki wilayah serta unggah poligon GeoJSON untuk validasi spasial.</p>
            <x-button :href="route('admin.wilayah.index')" :navigate="true" variant="secondary" size="sm" icon="arrow-right">
                Kelola Wilayah
            </x-button>
        </x-card>

        <x-card title="Master Layanan & Konten" subtitle="Kategori laporan, jenis surat, dan informasi desa">
            <p class="text-sm text-[#6B7280] mb-4">Siapkan kategori pengaduan, template persyaratan surat, serta berita publik.</p>
            <div class="flex flex-wrap gap-2">
                <x-button :href="route('admin.kategori-laporan.index')" :navigate="true" variant="outline" size="sm">
                    Kategori
                </x-button>
                <x-button :href="route('admin.jenis-surat.index')" :navigate="true" variant="outline" size="sm">
                    Jenis Surat
                </x-button>
                <x-button :href="route('admin.berita.index')" :navigate="true" variant="outline" size="sm">
                    Berita
                </x-button>
            </div>
        </x-card>
    </div>
@endsection
