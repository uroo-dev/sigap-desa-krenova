<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warga extends Model
{
    protected $table = 'warga';

    protected $fillable = [
        'user_id',
        'keluarga_id',
        'rt_id',
        'nik',
        'nik_hash',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'agama',
        'pekerjaan',
        'status_keluarga',
        'alamat',
        'no_hp',
    ];

    protected $hidden = [
        'nik',
        'nik_hash',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nik' => 'encrypted',
            'tanggal_lahir' => 'date',
        ];
    }

    protected static function booted(): void
    {
        // Simpan hash SHA-256 NIK agar validasi keunikan dan pencarian tetap berjalan aman
        static::saving(function (self $warga): void {
            if ($warga->isDirty('nik') && filled($warga->nik)) {
                $warga->nik_hash = hash('sha256', (string) $warga->nik);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function rt(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'rt_id');
    }
}
