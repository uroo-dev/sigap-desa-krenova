<!DOCTYPE html>
<html lang="id">
<head>
    @include('components.head-assets')
    <title>@yield('title', 'SIGAP — Sistem Informasi Geografis dan Aspirasi Publik')</title>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-[#F5F8F1] text-[#1F2937] antialiased">
    {{-- Topbar Publik (68px) --}}
    <header class="sticky top-0 z-40 h-[68px] bg-white border-b border-[#E5E7EB]">
        <div class="max-w-[1440px] mx-auto h-full px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center">
                <x-logo variant="primary" size="md" />
            </a>

            {{-- Navigasi Desktop --}}
            <nav class="hidden md:flex items-center gap-1">
                @php
                    $navLinks = [
                        ['route' => 'home', 'match' => 'home', 'label' => 'Beranda', 'icon' => 'layout-dashboard'],
                        ['route' => 'publik.peta', 'match' => 'publik.peta', 'label' => 'Peta Desa', 'icon' => 'map'],
                        ['route' => 'publik.potensi', 'match' => 'publik.potensi', 'label' => 'Potensi', 'icon' => 'compass'],
                        ['route' => 'publik.informasi', 'match' => 'publik.informasi*', 'label' => 'Informasi', 'icon' => 'file-text'],
                        ['route' => 'publik.laporan', 'match' => 'publik.laporan*', 'label' => 'Laporan Publik', 'icon' => 'clipboard-list'],
                    ];
                @endphp

                @foreach ($navLinks as $item)
                    @php $active = request()->routeIs($item['match']); @endphp
                    <a
                        href="{{ route($item['route']) }}"
                        @class([
                            'inline-flex items-center gap-2 px-3.5 py-2 rounded-lg text-sm font-medium transition-colors',
                            'bg-[#E7F1E9] text-[#1B5E3B]' => $active,
                            'text-[#6B7280] hover:text-[#1F2937] hover:bg-[#F8FAF7]' => ! $active,
                        ])
                    >
                        <i data-lucide="{{ $item['icon'] }}" class="w-[18px] h-[18px]"></i>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2.5">
                @auth
                    <x-button :href="route('dashboard')" variant="primary" size="md" icon="layout-dashboard">
                        Dashboard
                    </x-button>
                @else
                    <x-button :href="route('login')" variant="outline" size="md" class="hidden sm:inline-flex">
                        Masuk
                    </x-button>
                    <x-button :href="route('register')" variant="primary" size="md">
                        Daftar Warga
                    </x-button>
                @endauth

                {{-- Toggle Menu Mobile --}}
                <button
                    type="button"
                    onclick="document.getElementById('mobile-public-nav').classList.toggle('hidden')"
                    class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg border border-[#E5E7EB] text-[#1F2937] hover:bg-[#F8FAF7]"
                    aria-label="Buka menu navigasi"
                >
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        {{-- Drawer Mobile --}}
        <div id="mobile-public-nav" class="hidden md:hidden bg-white border-b border-[#E5E7EB] px-4 py-3 space-y-1">
            @foreach ($navLinks as $item)
                <a
                    href="{{ route($item['route']) }}"
                    @class([
                        'flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium',
                        'bg-[#E7F1E9] text-[#1B5E3B]' => request()->routeIs($item['match']),
                        'text-[#6B7280] hover:bg-[#F8FAF7]' => ! request()->routeIs($item['match']),
                    ])
                >
                    <i data-lucide="{{ $item['icon'] }}" class="w-[18px] h-[18px]"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
            @guest
                <div class="pt-2 border-t border-[#E5E7EB] flex gap-2">
                    <x-button :href="route('login')" variant="outline" size="md" class="w-full">Masuk</x-button>
                </div>
            @endguest
        </div>
    </header>

    {{-- Konten Utama --}}
    <main class="flex-1">
        @if (session()->hasAny(['success', 'error', 'warning', 'info']) || $errors->any())
            <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                <x-toast />
            </div>
        @endif
        @yield('content')
    </main>

    {{-- Footer Minimalis --}}
    <footer class="bg-white border-t border-[#E5E7EB] mt-12">
        <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <x-logo variant="primary" size="sm" :showTagline="true" />
            <p class="text-xs text-[#6B7280]">
                &copy; {{ date('Y') }} SIGAP — Sistem Informasi Geografis dan Aspirasi Publik (KRENOVA).
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
