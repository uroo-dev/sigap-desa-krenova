@props([
    'label' => null,
    'name',
    'required' => false,
    'helper' => null,
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-[#1F2937] mb-1.5">
            {{ $label }}
            @if ($required)
                <span class="text-[#DC2626]">*</span>
            @endif
        </label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        @if ($required) required @endif
        {{ $attributes->merge([
            'class' => 'w-full h-10 px-3 rounded-lg border text-sm text-[#1F2937] bg-white focus:outline-none focus:ring-2 focus:ring-[#1B5E3B]/20 focus:border-[#1B5E3B] transition-colors '
                .($errors->has($name) ? 'border-[#DC2626]' : 'border-[#D1D5DB]'),
        ]) }}
    >
        {{ $slot }}
    </select>

    @if ($helper)
        <p class="mt-1 text-xs text-[#6B7280]">{{ $helper }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-xs text-[#DC2626]">{{ $message }}</p>
    @enderror
</div>
