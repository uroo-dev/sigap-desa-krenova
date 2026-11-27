<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RoleName;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Arahkan pengguna ke halaman persetujuan OAuth Google.
     */
    public function redirect(): RedirectResponse
    {
        if (blank(config('services.google.client_id')) || blank(config('services.google.client_secret'))) {
            return redirect()->route('login')
                ->with('error', 'Login Google belum dikonfigurasi. Isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET pada file .env terlebih dahulu.');
        }

        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Tangani callback dari Google OAuth dan sinkronkan akun pengguna.
     */
    public function callback(Request $request): RedirectResponse
    {
        if (blank(config('services.google.client_id')) || blank(config('services.google.client_secret'))) {
            return redirect()->route('login')
                ->with('error', 'Login Google belum dikonfigurasi pada server.');
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')
                ->with('error', 'Login Google gagal atau dibatalkan. Silakan coba kembali.')
                ->withErrors(['email' => 'Login Google gagal. Silakan coba lagi.']);
        }

        $user = User::query()
            ->where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        $isNewUser = false;

        if ($user) {
            $user->forceFill([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        } else {
            $isNewUser = true;
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => null,
                'is_active' => true,
            ]);

            $user->markEmailAsVerified();
            $user->assignRole(RoleName::MASYARAKAT->value);
        }

        if (! $user->is_active) {
            return redirect()->route('login')
                ->with('error', 'Akun Anda saat ini dinonaktifkan. Hubungi Admin desa.')
                ->withErrors(['email' => 'Akun Anda saat ini dinonaktifkan.']);
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        $message = $isNewUser
            ? 'Akun berhasil didaftarkan dan masuk menggunakan Google.'
            : 'Berhasil masuk dengan akun Google Anda.';

        return redirect()->intended(route('dashboard'))->with('success', $message);
    }
}
