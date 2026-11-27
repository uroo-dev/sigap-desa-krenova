<!DOCTYPE html>
<html lang="id">
<head>
    @include('components.head-assets')
    <title>@yield('title', 'Autentikasi — SIGAP')</title>
</head>
<body class="min-h-screen bg-[#F5F8F1] text-[#1F2937] antialiased flex flex-col justify-center py-10 px-4 sm:px-6">
    <div class="w-full max-w-md mx-auto">
        <div class="flex flex-col items-center text-center mb-6" data-gsap="fade-up">
            <a href="{{ route('home') }}" class="inline-flex">
                <x-logo variant="primary" size="lg" />
            </a>
            <p class="mt-2 text-sm text-[#6B7280]">Desa Terhubung, Masyarakat Terlayani.</p>
        </div>

        <div class="bg-white border border-[#E5E7EB] rounded-xl p-6 sm:p-8" data-gsap="fade-up">
            <x-toast />
            @yield('content')
        </div>

        <p class="mt-6 text-center text-xs text-[#6B7280]">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 hover:text-[#1B5E3B] font-medium">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                Kembali ke Beranda Publik
            </a>
        </p>
    </div>
</body>
</html>
