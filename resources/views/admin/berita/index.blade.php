@extends('layouts.admin')

@section('title', 'Berita & Konten — Admin SIGAP')
@section('page-title', 'Berita & Konten Publik')
@section('page-subtitle', 'Kelola berita desa, pengumuman warga, dan agenda kegiatan')

@section('content')
    <div data-gsap="fade-up">
        <livewire:admin.berita-table />
    </div>
@endsection
