@extends('layouts.admin')

@section('title', 'Tambah Kategori Laporan — Admin SIGAP')
@section('page-title', 'Tambah Kategori Laporan')

@section('content')
    <div class="max-w-3xl" data-gsap="fade-up">
        <x-card title="Formulir Kategori Baru">
            <x-slot:actions>
                <x-button :href="route('admin.kategori-laporan.index')" :navigate="true" variant="ghost" size="sm" icon="arrow-left">Kembali</x-button>
            </x-slot:actions>

            <form method="POST" action="{{ route('admin.kategori-laporan.store') }}" class="space-y-6">
                @csrf
                @include('admin.kategori-laporan._form')

                <div class="flex justify-end gap-3 pt-4 border-t border-[#E5E7EB]">
                    <x-button :href="route('admin.kategori-laporan.index')" :navigate="true" variant="outline" size="md">Batal</x-button>
                    <x-button type="submit" variant="primary" size="md" icon="save">Simpan Kategori</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
