@props([
    'variant' => 'primary', // primary | secondary | outline | ghost | danger
    'size' => 'md',         // sm | md | lg
    'href' => null,
    'type' => 'button',
    'navigate' => false,
    'icon' => null,
])

@php
    $variants = [
        'primary' => 'bg-[#1B5E3B] text-white hover:bg-[#15452D] border border-transparent focus:ring-[#1B5E3B]/30',
        'secondary' => 'bg-[#E7F1E9] text-[#1B5E3B] hover:bg-[#d8e8dc] border border-transparent focus:ring-[#1B5E3B]/20',
        'outline' => 'bg-white text-[#1F2937] border border-[#D1D5DB] hover:bg-[#F8FAF7] hover:border-[#9CA3AF] focus:ring-[#1B5E3B]/20',
        'ghost' => 'bg-transparent text-[#6B7280] hover:text-[#1F2937] hover:bg-[#E7F1E9]/50 border border-transparent focus:ring-[#1B5E3B]/20',
        'danger' => 'bg-[#DC2626] text-white hover:bg-red-700 border border-transparent focus:ring-red-500/30',
    ];

    $sizes = [
        'sm' => 'h-8 px-3 text-xs gap-1.5',
        'md' => 'h-10 px-4 text-sm gap-2',
        'lg' => 'h-12 px-5 text-base gap-2',
    ];

    $baseClass = 'inline-flex items-center justify-center font-medium rounded-lg transition-colors duration-150 focus:outline-none focus:ring-2 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer';
    $classes = $baseClass.' '.($variants[$variant] ?? $variants['primary']).' '.($sizes[$size] ?? $sizes['md']);
@endphp

@if ($href)
    <a href="{{ $href }}" @if ($navigate) wire:navigate @endif {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <i data-lucide="{{ $icon }}" class="w-4 h-4 shrink-0"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <i data-lucide="{{ $icon }}" class="w-4 h-4 shrink-0"></i>
        @endif
        {{ $slot }}
    </button>
@endif
