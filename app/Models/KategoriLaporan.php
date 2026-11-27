<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriLaporan extends Model
{
    protected $table = 'kategori_laporan';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'ikon',
        'aktif',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'aktif' => true,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'kategori_id');
    }
}
