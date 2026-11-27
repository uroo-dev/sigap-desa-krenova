<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();
            $table->text('no_kk'); // Disimpan terenkripsi melalui cast Eloquent
            $table->string('no_kk_hash', 64)->unique(); // Hash SHA-256 untuk cek keunikan & pencarian
            $table->foreignId('rt_id')->nullable()
                ->constrained('wilayah')
                ->nullOnDelete();
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keluarga');
    }
};
