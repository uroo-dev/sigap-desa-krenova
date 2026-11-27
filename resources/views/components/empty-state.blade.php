@props([
    'icon' => 'inbox',
    'title' => 'Belum ada data',
    'description' => 'Data yang ditambahkan akan tampil di sini.',
])

<div class="py-12 px-6 text-center">
    <div class="mx-auto w-11 h-11 rounded-xl bg-[#F8FAF7] border border-[#E5E7EB] flex items-center justify-center text-[#6B7280] mb-3">
        <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
    </div>
    <h4 class="font-heading text-sm font-semibold text-[#1F2937]">{{ $title }}</h4>
    <p class="mt-1 text-xs text-[#6B7280] max-w-sm mx-auto">{{ $description }}</p>
    @if ($slot->isNotEmpty())
        <div class="mt-4">{{ $slot }}</div>
    @endif
</div>
