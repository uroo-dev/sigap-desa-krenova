@extends('layouts.admin')

@section('title', 'Wilayah & GIS — Admin SIGAP')
@section('page-title', 'Wilayah & GIS')
@section('page-subtitle', 'Kelola hierarki Desa, Dusun, RW, RT beserta batas poligon GeoJSON')

@section('content')
    <div data-gsap="fade-up">
        <livewire:admin.wilayah-table />
    </div>
@endsection
