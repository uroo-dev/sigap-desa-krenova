@props([
    'title' => null,
    'subtitle' => null,
    'flush' => false,
])

<div {{ $attributes->merge(['class' => 'bg-white border border-[#E5E7EB] rounded-xl overflow-hidden']) }}>
    @if ($title || isset($actions))
        <div class="px-6 py-4 border-b border-[#E5E7EB] flex flex-wrap items-center justify-between gap-3">
            <div>
                @if ($title)
                    <h3 class="font-heading text-base font-semibold text-[#1F2937]">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="text-xs text-[#6B7280] mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @isset($actions)
                <div class="flex items-center gap-2">{{ $actions }}</div>
            @endisset
        </div>
    @endif

    <div @class(['p-6' => ! $flush])>
        {{ $slot }}
    </div>
</div>
