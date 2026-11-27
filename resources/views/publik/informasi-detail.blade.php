@extends('layouts.app')

@section('title', $berita->judul.' — Informasi Desa SIGAP')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6" data-gsap="fade-up">
            <a href="{{ route('publik.informasi') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-[#6B7280] hover:text-[#1B5E3B]">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Kembali ke Informasi Desa
            </a>
        </div>

        <x-card data-gsap="fade-up">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <x-badge tone="primary">{{ ucfirst($berita->tipe) }}</x-badge>
                <span class="text-xs text-[#6B7280]">
                    Dipublikasikan {{ $berita->published_at?->translatedFormat('d F Y, H:i') }}
                </span>
            </div>

            <h1 class="font-heading text-2xl sm:text-3xl font-bold text-[#1F2937] leading-tight">
                {{ $berita->judul }}
            </h1>

            @if ($berita->ringkasan)
                <p class="mt-3 text-base text-[#6B7280] leading-relaxed border-l-4 border-[#A7C957] pl-4">
                    {{ $berita->ringkasan }}
                </p>
            @endif

            <div class="mt-6 pt-6 border-t border-[#E5E7EB] text-sm text-[#1F2937] leading-relaxed whitespace-pre-line">
                {{ $berita->isi }}
            </div>
        </x-card>
    </div>
@endsection
