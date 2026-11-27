@extends('layouts.admin')

@section('title', 'Buat Konten — Admin SIGAP')
@section('page-title', 'Buat Konten Baru')

@section('content')
    <div class="max-w-3xl" data-gsap="fade-up">
        <x-card title="Formulir Konten Publik">
            <x-slot:actions>
                <x-button :href="route('admin.berita.index')" :navigate="true" variant="ghost" size="sm" icon="arrow-left">Kembali</x-button>
            </x-slot:actions>

            <form method="POST" action="{{ route('admin.berita.store') }}" class="space-y-6">
                @csrf
                @include('admin.berita._form')

                <div class="flex justify-end gap-3 pt-4 border-t border-[#E5E7EB]">
                    <x-button :href="route('admin.berita.index')" :navigate="true" variant="outline" size="md">Batal</x-button>
                    <x-button type="submit" variant="primary" size="md" icon="save">Simpan Konten</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
