@extends('layouts.admin')

@section('title', 'Kategori Laporan — Admin SIGAP')
@section('page-title', 'Kategori Laporan')
@section('page-subtitle', 'Master kategori pengaduan dan aspirasi masyarakat')

@section('content')
    <div data-gsap="fade-up">
        <livewire:admin.kategori-laporan-table />
    </div>
@endsection
