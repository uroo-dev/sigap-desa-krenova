<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'persyaratan',
        'template_isi',
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
            'persyaratan' => 'array',
            'aktif' => 'boolean',
        ];
    }

    public function surat(): HasMany
    {
        return $this->hasMany(Surat::class, 'jenis_surat_id');
    }
}
