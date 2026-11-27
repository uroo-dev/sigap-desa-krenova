<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keluarga extends Model
{
    protected $table = 'keluarga';

    protected $fillable = [
        'no_kk',
        'no_kk_hash',
        'rt_id',
        'alamat',
    ];

    protected $hidden = [
        'no_kk',
        'no_kk_hash',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'no_kk' => 'encrypted',
        ];
    }

    protected static function booted(): void
    {
        // Hitung hash SHA-256 dari nomor KK asli agar pengecekan unik tetap bisa dilakukan meski kolom terenkripsi
        static::saving(function (self $keluarga): void {
            if ($keluarga->isDirty('no_kk') && filled($keluarga->no_kk)) {
                $keluarga->no_kk_hash = hash('sha256', (string) $keluarga->no_kk);
            }
        });
    }

    public function anggota(): HasMany
    {
        return $this->hasMany(Warga::class, 'keluarga_id');
    }

    public function rt(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'rt_id');
    }
}
