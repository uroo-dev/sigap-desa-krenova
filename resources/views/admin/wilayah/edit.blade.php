@extends('layouts.admin')

@section('title', 'Edit Wilayah — Admin SIGAP')
@section('page-title', 'Edit Wilayah')
@section('page-subtitle', $wilayah->nama)

@section('content')
    <div class="max-w-3xl" data-gsap="fade-up">
        <x-card title="Perbarui Wilayah">
            <x-slot:actions>
                <x-button :href="route('admin.wilayah.index')" :navigate="true" variant="ghost" size="sm" icon="arrow-left">Kembali</x-button>
            </x-slot:actions>

            <form method="POST" action="{{ route('admin.wilayah.update', $wilayah) }}" class="space-y-6">
                @csrf
                @method('PUT')
                @include('admin.wilayah._form')

                <div class="flex justify-end gap-3 pt-4 border-t border-[#E5E7EB]">
                    <x-button :href="route('admin.wilayah.index')" :navigate="true" variant="outline" size="md">Batal</x-button>
                    <x-button type="submit" variant="primary" size="md" icon="save">Simpan Perubahan</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
