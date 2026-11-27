<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()
                ->constrained('wilayah')
                ->nullOnDelete();
            $table->enum('tipe', ['desa', 'dusun', 'rw', 'rt']);
            $table->string('nama');
            $table->string('kode', 32)->nullable()->unique();
            $table->json('geojson')->nullable();
            $table->timestamps();

            $table->index(['tipe', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};
