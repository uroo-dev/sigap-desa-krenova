@extends('layouts.admin')

@section('title', 'Pengguna & Role — Admin SIGAP')
@section('page-title', 'Pengguna & Role')
@section('page-subtitle', 'Kelola akun pengguna, status aktif, dan penetapan wilayah RT dalam modal interaktif')

@section('content')
    <div data-gsap="fade-up">
        <livewire:admin.user-table />
    </div>
@endsection
