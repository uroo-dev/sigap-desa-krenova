<?php

namespace App\Enums;

/**
 * Siklus status pengajuan dan penerbitan surat digital desa.
 */
enum SuratStatus: string
{
    case DRAFT = 'draft';
    case DIAJUKAN = 'diajukan';
    case DIVERIFIKASI_RT = 'diverifikasi_rt';
    case DITOLAK_RT = 'ditolak_rt';
    case MENUNGGU_KADES = 'menunggu_kades';
    case DISETUJUI_KADES = 'disetujui_kades';
    case DITOLAK_KADES = 'ditolak_kades';
    case DITERBITKAN = 'diterbitkan';
    case DIBATALKAN = 'dibatalkan';

    /**
     * Label status pengajuan surat.
     */
    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draf',
            self::DIAJUKAN => 'Diajukan',
            self::DIVERIFIKASI_RT => 'Diverifikasi RT',
            self::DITOLAK_RT => 'Ditolak RT',
            self::MENUNGGU_KADES => 'Menunggu Persetujuan Kades',
            self::DISETUJUI_KADES => 'Disetujui Kepala Desa',
            self::DITOLAK_KADES => 'Ditolak Kepala Desa',
            self::DITERBITKAN => 'Diterbitkan',
            self::DIBATALKAN => 'Dibatalkan',
        };
    }
}
