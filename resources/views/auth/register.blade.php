{{-- Stub view register: siap disesuaikan dengan desain UI Anda --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - {{ config('app.name', 'SIGAP') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('sigap.ico') }}">
</head>
<body>
    <h1>Daftar Akun SIGAP</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="No. HP (Opsional)">
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
        <button type="submit">Daftar</button>
    </form>
    <p><a href="{{ route('auth.google') }}">Daftar / Masuk dengan Google</a></p>
</body>
</html>
