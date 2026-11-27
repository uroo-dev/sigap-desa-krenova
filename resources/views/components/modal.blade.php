@props([
    'name' => null,
    'show' => false,
    'onClose' => 'closeModals',
    'title' => null,
    'subtitle' => null,
    'maxWidth' => 'lg', // sm | md | lg | xl | 2xl
])

@php
    $widths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ];
    $maxWidthClass = $widths[$maxWidth] ?? $widths['lg'];
@endphp

@if ($name)
    <div
        x-data="{ open: false }"
        x-on:open-modal.window="if ($event.detail === '{{ $name }}' || $event.detail?.name === '{{ $name }}') open = true"
        x-on:close-modal.window="if (!$event.detail || $event.detail === '{{ $name }}' || $event.detail?.name === '{{ $name }}') open = false"
        x-on:keydown.escape.window="open = false"
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-6 flex items-center justify-center"
        role="dialog"
        aria-modal="true"
    >
        <div x-show="open" @click="open = false" class="fixed inset-0 bg-black/40"></div>
        <div @click.stop class="relative w-full {{ $maxWidthClass }} bg-white border border-[#E5E7EB] rounded-xl shadow-lg overflow-hidden my-auto">
            @if ($title)
                <div class="px-6 py-4 border-b border-[#E5E7EB] flex items-start justify-between gap-4">
                    <div>
                        <h3 class="font-heading text-base font-semibold text-[#1F2937]">{{ $title }}</h3>
                        @if ($subtitle)
                            <p class="text-xs text-[#6B7280] mt-0.5">{{ $subtitle }}</p>
                        @endif
                    </div>
                    <button type="button" @click="open = false" class="w-8 h-8 rounded-lg inline-flex items-center justify-center text-[#6B7280] hover:text-[#1F2937] hover:bg-[#F8FAF7]" aria-label="Tutup modal">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif
            <div class="p-6 max-h-[80vh] overflow-y-auto">{{ $slot }}</div>
        </div>
    </div>
@elseif ($show)
    <div
        x-data
        x-on:keydown.escape.window="$wire.{{ $onClose }}()"
        class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-6 flex items-center justify-center"
        role="dialog"
        aria-modal="true"
    >
        <div wire:click="{{ $onClose }}" class="fixed inset-0 bg-black/40"></div>
        <div class="relative w-full {{ $maxWidthClass }} bg-white border border-[#E5E7EB] rounded-xl shadow-lg overflow-hidden my-auto">
            @if ($title)
                <div class="px-6 py-4 border-b border-[#E5E7EB] flex items-start justify-between gap-4">
                    <div>
                        <h3 class="font-heading text-base font-semibold text-[#1F2937]">{{ $title }}</h3>
                        @if ($subtitle)
                            <p class="text-xs text-[#6B7280] mt-0.5">{{ $subtitle }}</p>
                        @endif
                    </div>
                    <button
                        type="button"
                        wire:click="{{ $onClose }}"
                        class="w-8 h-8 rounded-lg inline-flex items-center justify-center text-[#6B7280] hover:text-[#1F2937] hover:bg-[#F8FAF7]"
                        aria-label="Tutup modal"
                    >
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif
            <div class="p-6 max-h-[80vh] overflow-y-auto">
                {{ $slot }}
            </div>
        </div>
    </div>
@endif
