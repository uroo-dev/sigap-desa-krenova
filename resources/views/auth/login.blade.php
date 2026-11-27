@extends('layouts.guest')

@section('title', 'Masuk — SIGAP')

@section('content')
    <div class="mb-6">
        <h1 class="font-heading text-xl font-bold text-[#1F2937]">Masuk ke Akun Anda</h1>
        <p class="mt-1 text-sm text-[#6B7280]">Akses layanan aspirasi, peta desa, dan administrasi surat digital.</p>
    </div>

    {{-- Google OAuth Login --}}
    <a
        href="{{ route('auth.google') }}"
        class="w-full h-10 px-4 rounded-lg border border-[#D1D5DB] bg-white hover:bg-[#F8FAF7] text-sm font-medium text-[#1F2937] inline-flex items-center justify-center gap-2.5 transition-colors"
    >
        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
            <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17Z" />
            <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.11-6.72-4.96H1.29v3.14C3.26 21.3 7.31 24 12 24Z" />
            <path fill="#FBBC05" d="M5.28 14.24c-.24-.72-.38-1.49-.38-2.24s.14-1.52.38-2.24V6.62H1.29C.47 8.24 0 10.06 0 12s.47 3.76 1.29 5.38l3.99-3.14Z" />
            <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.62l3.99 3.14c.95-2.85 3.6-4.96 6.72-4.96Z" />
        </svg>
        <span>Masuk dengan Google</span>
    </a>

    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-[#E5E7EB]"></div>
        </div>
        <div class="relative flex justify-center text-xs uppercase">
            <span class="bg-white px-3 text-[#9CA3AF]">Atau dengan email</span>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <x-input
            label="Alamat Email"
            name="email"
            type="email"
            placeholder="nama@email.com"
            required
            autocomplete="email"
        />

        <x-input
            label="Kata Sandi"
            name="password"
            type="password"
            placeholder="Masukkan kata sandi"
            required
            autocomplete="current-password"
        />

        <div class="flex items-center justify-between pt-1">
            <label class="inline-flex items-center gap-2 text-sm text-[#6B7280] cursor-pointer">
                <input type="checkbox" name="remember" value="1" class="rounded border-[#D1D5DB] text-[#1B5E3B] focus:ring-[#1B5E3B]/30">
                <span>Ingat saya</span>
            </label>
        </div>

        <x-button type="submit" variant="primary" size="md" class="w-full" icon="log-in">
            Masuk
        </x-button>
    </form>

    <p class="mt-6 text-center text-sm text-[#6B7280]">
        Belum memiliki akun warga?
        <a href="{{ route('register') }}" class="font-semibold text-[#1B5E3B] hover:text-[#15452D]">Daftar di sini</a>
    </p>
@endsection
