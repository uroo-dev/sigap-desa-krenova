{{-- Stub view publik.beranda: siap disesuaikan dengan desain UI Anda --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda - {{ config('app.name', 'SIGAP') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('sigap.ico') }}">
</head>
<body>
    <h1>SIGAP — Beranda Publik</h1>
    <p>Total Laporan: {{ $totalLaporan }} | Laporan Selesai: {{ $laporanSelesai }}</p>
    <nav>
        <a href="{{ route('publik.peta') }}">Peta Desa</a> |
        <a href="{{ route('publik.potensi') }}">Potensi Desa</a> |
        <a href="{{ route('publik.informasi') }}">Informasi Desa</a> |
        <a href="{{ route('publik.laporan') }}">Laporan Publik</a> |
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Masuk</a>
        @endauth
    </nav>
</body>
</html>
