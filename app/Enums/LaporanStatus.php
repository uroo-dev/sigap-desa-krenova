<?php

namespace App\Enums;

/**
 * Siklus status penanganan laporan masalah warga (GIS).
 */
enum LaporanStatus: string
{
    case BARU = 'baru';
    case DIVERIFIKASI_RT = 'diverifikasi_rt';
    case DITOLAK_RT = 'ditolak_rt';
    case DIAJUKAN_KE_KADES = 'diajukan_ke_kades';
    case DIINSTRUKSIKAN = 'diinstruksikan';
    case DALAM_PROSES = 'dalam_proses';
    case SELESAI_RT = 'selesai_rt';
    case DIVALIDASI_KADES = 'divalidasi_kades';
    case DITINJAU_ULANG = 'ditinjau_ulang';
    case ARSIP = 'arsip';

    /**
     * Label status yang ramah dibaca pengguna.
     */
    public function label(): string
    {
        return match ($this) {
            self::BARU => 'Baru Masuk',
            self::DIVERIFIKASI_RT => 'Diverifikasi RT',
            self::DITOLAK_RT => 'Ditolak RT',
            self::DIAJUKAN_KE_KADES => 'Diajukan ke Kepala Desa',
            self::DIINSTRUKSIKAN => 'Diinstruksikan',
            self::DALAM_PROSES => 'Dalam Proses',
            self::SELESAI_RT => 'Selesai oleh RT',
            self::DIVALIDASI_KADES => 'Divalidasi Kepala Desa',
            self::DITINJAU_ULANG => 'Ditinjau Ulang',
            self::ARSIP => 'Diarsipkan',
        };
    }
}
