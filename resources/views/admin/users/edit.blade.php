@extends('layouts.admin')

@section('title', 'Edit Pengguna — Admin SIGAP')
@section('page-title', 'Edit Pengguna')
@section('page-subtitle', $user->name)

@section('content')
    <div class="max-w-3xl" data-gsap="fade-up">
        <x-card title="Perbarui Data Pengguna">
            <x-slot:actions>
                <x-button :href="route('admin.users.index')" :navigate="true" variant="ghost" size="sm" icon="arrow-left">
                    Kembali
                </x-button>
            </x-slot:actions>

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                @csrf
                @method('PUT')
                @include('admin.users._form')

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E5E7EB]">
                    <x-button :href="route('admin.users.index')" :navigate="true" variant="outline" size="md">
                        Batal
                    </x-button>
                    <x-button type="submit" variant="primary" size="md" icon="save">
                        Simpan Perubahan
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
