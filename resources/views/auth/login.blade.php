{{-- Stub view login: siap disesuaikan dengan desain UI Anda --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - {{ config('app.name', 'SIGAP') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('sigap.ico') }}">
</head>
<body>
    <h1>Masuk ke SIGAP</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <label><input type="checkbox" name="remember"> Ingat saya</label>
        <button type="submit">Masuk</button>
    </form>
    <p><a href="{{ route('auth.google') }}">Masuk dengan Google</a></p>
    <p><a href="{{ route('register') }}">Daftar Akun</a></p>
</body>
</html>
