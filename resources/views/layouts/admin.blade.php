<!DOCTYPE html>
<html lang="id">
<head>
    @include('components.head-assets')
    <title>@yield('title', 'Admin Panel — SIGAP')</title>
    @livewireStyles
    @stack('styles')
</head>
<body class="min-h-screen bg-[#F5F8F1] text-[#1F2937] antialiased">
    <div class="min-h-screen flex">
        {{-- Sidebar Persisten Tanpa Reload (Livewire @persist + wire:navigate) --}}
        @persist('admin-sidebar')
        <div
            x-data="{
                sidebarCollapsed: false,
                mobileOpen: false,
                currentPath: window.location.pathname
            }"
            x-on:toggle-admin-sidebar.window="mobileOpen = !mobileOpen"
            x-on:livewire:navigated.window="currentPath = window.location.pathname; mobileOpen = false"
            class="contents"
        >
            <div
                x-show="mobileOpen"
                x-cloak
                @click="mobileOpen = false"
                class="fixed inset-0 z-40 bg-black/30 lg:hidden"
            ></div>

            <aside
                :class="[
                    sidebarCollapsed ? 'lg:w-[76px]' : 'lg:w-[260px]',
                    mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
                ]"
                class="fixed lg:sticky top-0 left-0 z-50 h-screen w-[260px] shrink-0 bg-white border-r border-[#E5E7EB] flex flex-col transition-all duration-200"
            >
                {{-- Brand Sidebar (68px) --}}
                <div class="h-[68px] px-4 border-b border-[#E5E7EB] flex items-center justify-between gap-2">
                    <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-center overflow-hidden">
                        <span x-show="!sidebarCollapsed">
                            <x-logo variant="primary" size="sm" />
                        </span>
                        <span x-show="sidebarCollapsed" x-cloak>
                            <x-logo variant="icon" size="sm" />
                        </span>
                    </a>

                    <button
                        type="button"
                        @click="sidebarCollapsed = !sidebarCollapsed"
                        class="hidden lg:inline-flex items-center justify-center w-8 h-8 rounded-lg text-[#6B7280] hover:text-[#1F2937] hover:bg-[#F8FAF7]"
                        title="Ciutkan / Perluas Sidebar"
                    >
                        <i data-lucide="panel-left" class="w-[18px] h-[18px]"></i>
                    </button>
                </div>

                {{-- Navigasi Menu Admin dengan wire:navigate (SPA tanpa reload) --}}
                @php
                    $adminMenus = [
                        ['label' => 'Dashboard', 'href' => route('admin.dashboard'), 'prefix' => '/admin', 'exact' => true, 'icon' => 'layout-dashboard'],
                        ['label' => 'Pengguna & Role', 'href' => route('admin.users.index'), 'prefix' => '/admin/users', 'exact' => false, 'icon' => 'users'],
                        ['label' => 'Wilayah & GIS', 'href' => route('admin.wilayah.index'), 'prefix' => '/admin/wilayah', 'exact' => false, 'icon' => 'map-pin'],
                        ['label' => 'Kategori Laporan', 'href' => route('admin.kategori-laporan.index'), 'prefix' => '/admin/kategori-laporan', 'exact' => false, 'icon' => 'clipboard-list'],
                        ['label' => 'Jenis Surat', 'href' => route('admin.jenis-surat.index'), 'prefix' => '/admin/jenis-surat', 'exact' => false, 'icon' => 'file-text'],
                        ['label' => 'Berita & Konten', 'href' => route('admin.berita.index'), 'prefix' => '/admin/berita', 'exact' => false, 'icon' => 'newspaper'],
                        ['label' => 'Pengaturan Desa', 'href' => route('admin.pengaturan.edit'), 'prefix' => '/admin/pengaturan-desa', 'exact' => false, 'icon' => 'settings'],
                    ];
                @endphp

                <nav class="flex-1 overflow-y-auto p-3 space-y-1">
                    @foreach ($adminMenus as $menu)
                        @php
                            $activeCondition = $menu['exact']
                                ? "currentPath === '{$menu['prefix']}'"
                                : "currentPath.startsWith('{$menu['prefix']}')";
                        @endphp
                        <a
                            href="{{ $menu['href'] }}"
                            wire:navigate
                            :class="{{ $activeCondition }}
                                ? 'bg-[#E7F1E9] text-[#1B5E3B] font-semibold'
                                : 'text-[#6B7280] hover:text-[#1F2937] hover:bg-[#F8FAF7] font-medium'"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors"
                        >
                            <i data-lucide="{{ $menu['icon'] }}" class="w-[18px] h-[18px] shrink-0"></i>
                            <span x-show="!sidebarCollapsed" class="truncate">{{ $menu['label'] }}</span>
                        </a>
                    @endforeach
                </nav>

                {{-- Footer Sidebar --}}
                <div class="p-3 border-t border-[#E5E7EB] space-y-1">
                    <a
                        href="{{ route('home') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-[#6B7280] hover:text-[#1F2937] hover:bg-[#F8FAF7]"
                    >
                        <i data-lucide="globe" class="w-[18px] h-[18px] shrink-0"></i>
                        <span x-show="!sidebarCollapsed" class="truncate">Lihat Portal Publik</span>
                    </a>
                </div>
            </aside>
        </div>
        @endpersist

        {{-- Kolom Konten Utama --}}
        <div class="flex-1 min-w-0 flex flex-col">
            {{-- Topbar Admin (68px) --}}
            <header class="sticky top-0 z-30 h-[68px] bg-white border-b border-[#E5E7EB] px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        onclick="window.dispatchEvent(new CustomEvent('toggle-admin-sidebar'))"
                        class="lg:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg border border-[#E5E7EB] text-[#1F2937]"
                        aria-label="Buka sidebar"
                    >
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div>
                        <h1 class="font-heading text-lg font-bold text-[#1F2937]">@yield('page-title', 'Dashboard Admin')</h1>
                        @hasSection('page-subtitle')
                            <p class="text-xs text-[#6B7280] hidden sm:block">@yield('page-subtitle')</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2.5 px-3 py-1.5 rounded-lg bg-[#F8FAF7] border border-[#E5E7EB]">
                        <i data-lucide="shield-check" class="w-4 h-4 text-[#1B5E3B]"></i>
                        <span class="text-xs font-medium text-[#1F2937]">{{ auth()->user()->name }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-button type="submit" variant="outline" size="sm" icon="log-out">
                            Keluar
                        </x-button>
                    </form>
                </div>
            </header>

            {{-- Konten Halaman --}}
            <main class="flex-1 max-w-[1440px] w-full mx-auto p-4 sm:p-6 lg:p-8">
                <x-toast />
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
