@extends('layouts.admin')

@section('title', 'Tambah Pengguna — Admin SIGAP')
@section('page-title', 'Tambah Pengguna')
@section('page-subtitle', 'Buat akun baru dan tetapkan hak akses sistem')

@section('content')
    <div class="max-w-3xl" data-gsap="fade-up">
        <x-card title="Formulir Pengguna Baru">
            <x-slot:actions>
                <x-button :href="route('admin.users.index')" :navigate="true" variant="ghost" size="sm" icon="arrow-left">
                    Kembali
                </x-button>
            </x-slot:actions>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf
                @include('admin.users._form')

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E5E7EB]">
                    <x-button :href="route('admin.users.index')" :navigate="true" variant="outline" size="md">
                        Batal
                    </x-button>
                    <x-button type="submit" variant="primary" size="md" icon="save">
                        Simpan Pengguna
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
