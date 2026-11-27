<?php

namespace App\Models;

use App\Enums\LaporanStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use SoftDeletes;

    protected $table = 'laporan';

    protected $fillable = [
        'nomor_laporan',
        'user_id',
        'kategori_id',
        'rt_id',
        'judul',
        'deskripsi',
        'latitude',
        'longitude',
        'alamat_lokasi',
        'foto',
        'prioritas',
        'status',
        'catatan_rt',
        'catatan_kades',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'prioritas' => 'sedang',
        'status' => LaporanStatus::BARU->value,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => LaporanStatus::class,
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriLaporan::class, 'kategori_id');
    }

    public function rt(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'rt_id');
    }
}
