<?php

namespace App\Enums;

/**
 * Daftar role resmi pengguna pada sistem SIGAP.
 */
enum RoleName: string
{
    case MASYARAKAT = 'masyarakat';
    case KETUA_RT = 'ketua_rt';
    case KEPALA_DESA = 'kepala_desa';
    case ADMIN = 'admin';

    /**
     * Label tampilan berbahasa Indonesia untuk masing-masing role.
     */
    public function label(): string
    {
        return match ($this) {
            self::MASYARAKAT => 'Masyarakat',
            self::KETUA_RT => 'Ketua RT',
            self::KEPALA_DESA => 'Kepala Desa',
            self::ADMIN => 'Admin Sistem',
        };
    }
}
