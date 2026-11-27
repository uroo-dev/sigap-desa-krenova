@extends('layouts.admin')

@section('title', 'Tambah Jenis Surat — Admin SIGAP')
@section('page-title', 'Tambah Jenis Surat')

@section('content')
    <div class="max-w-3xl" data-gsap="fade-up">
        <x-card title="Formulir Jenis Surat Baru">
            <x-slot:actions>
                <x-button :href="route('admin.jenis-surat.index')" :navigate="true" variant="ghost" size="sm" icon="arrow-left">Kembali</x-button>
            </x-slot:actions>

            <form method="POST" action="{{ route('admin.jenis-surat.store') }}" class="space-y-6">
                @csrf
                @include('admin.jenis-surat._form')

                <div class="flex justify-end gap-3 pt-4 border-t border-[#E5E7EB]">
                    <x-button :href="route('admin.jenis-surat.index')" :navigate="true" variant="outline" size="md">Batal</x-button>
                    <x-button type="submit" variant="primary" size="md" icon="save">Simpan Jenis Surat</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
