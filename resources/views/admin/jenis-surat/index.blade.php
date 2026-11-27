@extends('layouts.admin')

@section('title', 'Jenis Surat — Admin SIGAP')
@section('page-title', 'Jenis Surat Digital')
@section('page-subtitle', 'Master layanan surat menyurat desa beserta persyaratan dan template PDF')

@section('content')
    <div data-gsap="fade-up">
        <livewire:admin.jenis-surat-table />
    </div>
@endsection
