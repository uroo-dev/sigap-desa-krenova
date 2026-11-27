<?php

namespace App\Models;

use App\Enums\SuratStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surat extends Model
{
    use SoftDeletes;

    protected $table = 'surat';

    protected $fillable = [
        'nomor_surat',
        'user_id',
        'jenis_surat_id',
        'rt_id',
        'data_isian',
        'status',
        'catatan_rt',
        'catatan_kades',
        'file_pdf',
        'tanggal_pengajuan',
        'tanggal_terbit',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'status' => SuratStatus::DRAFT->value,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data_isian' => 'array',
            'status' => SuratStatus::class,
            'tanggal_pengajuan' => 'datetime',
            'tanggal_terbit' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function rt(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'rt_id');
    }
}
