<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wilayah extends Model
{
    protected $table = 'wilayah';

    protected $fillable = [
        'parent_id',
        'tipe',
        'nama',
        'kode',
        'geojson',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'geojson' => 'array',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function warga(): HasMany
    {
        return $this->hasMany(Warga::class, 'rt_id');
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'rt_id');
    }

    public function surat(): HasMany
    {
        return $this->hasMany(Surat::class, 'rt_id');
    }

    public function scopeRt(Builder $query): Builder
    {
        return $query->where('tipe', 'rt');
    }
}
