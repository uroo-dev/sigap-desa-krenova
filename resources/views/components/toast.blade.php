@if (session('success'))
    <div data-gsap="fade-up" class="mb-5 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-[#16A34A]">
        <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0 mt-0.5"></i>
        <div class="flex-1 font-medium">{{ session('success') }}</div>
    </div>
@endif

@if (session('error'))
    <div data-gsap="fade-up" class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-[#DC2626]">
        <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
        <div class="flex-1 font-medium">{{ session('error') }}</div>
    </div>
@endif

@if ($errors->any())
    <div data-gsap="fade-up" class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-[#DC2626]">
        <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0 mt-0.5"></i>
        <div class="flex-1">
            <p class="font-semibold">Terdapat kesalahan pada data yang dikirim:</p>
            <ul class="mt-1 list-disc list-inside space-y-0.5 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
