<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_laporan', 32)->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategori_laporan');
            $table->foreignId('rt_id')->constrained('wilayah');
            $table->string('judul');
            $table->text('deskripsi');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->text('alamat_lokasi')->nullable();
            $table->string('foto')->nullable();
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->string('status', 32)->default('baru');
            $table->text('catatan_rt')->nullable();
            $table->text('catatan_kades')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['rt_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
