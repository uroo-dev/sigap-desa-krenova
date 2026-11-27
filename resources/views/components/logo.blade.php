@props([
    'variant' => 'primary', // primary | icon | monochrome
    'size' => 'md',         // sm | md | lg
    'inverted' => false,
    'showTagline' => false,
])

@php
    $iconSizes = [
        'sm' => 'w-7 h-7',
        'md' => 'w-9 h-9',
        'lg' => 'w-11 h-11',
    ];
    $textSizes = [
        'sm' => 'text-base',
        'md' => 'text-lg',
        'lg' => 'text-2xl',
    ];
    $iconClass = $iconSizes[$size] ?? $iconSizes['md'];
    $textClass = $textSizes[$size] ?? $textSizes['md'];

    $primaryFill = $variant === 'monochrome'
        ? ($inverted ? '#FFFFFF' : '#1F2937')
        : ($inverted ? '#A7C957' : '#1B5E3B');
    $accentFill = $variant === 'monochrome'
        ? ($inverted ? '#FFFFFF' : '#1F2937')
        : '#A7C957';
    $wordmarkColor = $inverted ? 'text-white' : 'text-[#1F2937]';
    $taglineColor = $inverted ? 'text-white/80' : 'text-[#6B7280]';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5 select-none']) }}>
    {{-- The Connected S: Monogram S + Pin Lokasi + Garis Lanskap Desa --}}
    <svg class="{{ $iconClass }} shrink-0" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <rect x="2" y="2" width="36" height="36" rx="10" fill="{{ $primaryFill }}" fill-opacity="{{ $variant === 'monochrome' ? '0.1' : '0.12' }}" />
        <path d="M12.5 28.5C15.8 25.4 24.2 25.4 27.5 28.5" stroke="{{ $accentFill }}" stroke-width="2.2" stroke-linecap="round" />
        <path d="M24.5 11.5C22.9 10.1 20.5 9.5 18.2 10.1C15.1 10.9 13.5 13.7 14.6 16.4C15.5 18.6 18.2 19.3 20.6 20.1C23.2 21 25.6 22 25.6 24.7C25.6 27.4 22.9 29.2 19.6 29C17.3 28.9 15.4 27.9 14.1 26.5" stroke="{{ $primaryFill }}" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round" />
        <circle cx="25.5" cy="12" r="3" fill="{{ $accentFill }}" />
        <circle cx="25.5" cy="12" r="1.2" fill="{{ $variant === 'monochrome' ? '#FFFFFF' : '#1B5E3B' }}" />
    </svg>

    @if ($variant !== 'icon')
        <span class="flex flex-col leading-none">
            <span class="font-heading font-bold tracking-tight {{ $textClass }} {{ $wordmarkColor }}">
                SIGAP
            </span>
            @if ($showTagline)
                <span class="text-[11px] font-medium mt-0.5 {{ $taglineColor }}">
                    Desa Terhubung, Masyarakat Terlayani.
                </span>
            @endif
        </span>
    @endif
</span>
