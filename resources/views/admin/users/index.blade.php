@extends('layouts.admin')

@section('title', 'Pengguna & Role — Admin SIGAP')
@section('page-title', 'Pengguna & Role')
@section('page-subtitle', 'Kelola akun pengguna, status aktif, dan penetapan wilayah RT')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6" data-gsap="fade-up">
        <p class="text-sm text-[#6B7280]">Pencarian, filter role, dan status akun berjalan langsung tanpa memuat ulang halaman.</p>
        <x-button :href="route('admin.users.create')" :navigate="true" variant="primary" size="md" icon="user-plus">
            Tambah Pengguna
        </x-button>
    </div>

    <div data-gsap="fade-up">
        <livewire:admin.user-table />
    </div>
@endsection
