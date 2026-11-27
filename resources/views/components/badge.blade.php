@props([
    'tone' => null,   // success | warning | danger | info | neutral | primary
    'status' => null, // Opsional: instance LaporanStatus atau SuratStatus
])

@php
    use App\Enums\LaporanStatus;
    use App\Enums\SuratStatus;

    $resolvedTone = $tone;
    $label = null;

    if ($status instanceof LaporanStatus) {
        $label = $status->label();
        $resolvedTone = match ($status) {
            LaporanStatus::BARU, LaporanStatus::DITINJAU_ULANG => 'warning',
            LaporanStatus::DIVERIFIKASI_RT, LaporanStatus::SELESAI_RT, LaporanStatus::DIVALIDASI_KADES => 'success',
            LaporanStatus::DITOLAK_RT => 'danger',
            LaporanStatus::DIAJUKAN_KE_KADES, LaporanStatus::DIINSTRUKSIKAN, LaporanStatus::DALAM_PROSES => 'info',
            LaporanStatus::ARSIP => 'neutral',
        };
    } elseif ($status instanceof SuratStatus) {
        $label = $status->label();
        $resolvedTone = match ($status) {
            SuratStatus::DRAFT, SuratStatus::DIBATALKAN => 'neutral',
            SuratStatus::DIAJUKAN, SuratStatus::MENUNGGU_KADES => 'warning',
            SuratStatus::DIVERIFIKASI_RT, SuratStatus::DISETUJUI_KADES => 'info',
            SuratStatus::DITERBITKAN => 'success',
            SuratStatus::DITOLAK_RT, SuratStatus::DITOLAK_KADES => 'danger',
        };
    }

    $tones = [
        'success' => 'bg-green-50 text-[#16A34A] border-green-200',
        'warning' => 'bg-amber-50 text-[#D97706] border-amber-200',
        'danger' => 'bg-red-50 text-[#DC2626] border-red-200',
        'info' => 'bg-blue-50 text-[#2563EB] border-blue-200',
        'primary' => 'bg-[#E7F1E9] text-[#1B5E3B] border-[#1B5E3B]/20',
        'neutral' => 'bg-[#F8FAF7] text-[#6B7280] border-[#E5E7EB]',
    ];

    $classes = 'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border '
        .($tones[$resolvedTone ?? 'neutral'] ?? $tones['neutral']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot->isNotEmpty() ? $slot : $label }}
</span>
