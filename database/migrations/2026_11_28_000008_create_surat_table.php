<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 64)->nullable()->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->foreignId('rt_id')->constrained('wilayah');
            $table->json('data_isian')->nullable();
            $table->string('status', 32)->default('draft');
            $table->text('catatan_rt')->nullable();
            $table->text('catatan_kades')->nullable();
            $table->string('file_pdf')->nullable();
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->timestamp('tanggal_terbit')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['rt_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
