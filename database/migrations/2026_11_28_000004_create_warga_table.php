<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('keluarga_id')->nullable()
                ->constrained('keluarga')
                ->nullOnDelete();
            $table->foreignId('rt_id')->nullable()
                ->constrained('wilayah')
                ->nullOnDelete();
            $table->text('nik'); // Disimpan terenkripsi melalui cast Eloquent
            $table->string('nik_hash', 64)->unique(); // Hash SHA-256 untuk cek keunikan & pencarian
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir')->nullable();
            $table->string('agama', 32)->nullable();
            $table->string('pekerjaan', 64)->nullable();
            $table->enum('status_keluarga', [
                'kepala_keluarga',
                'istri',
                'anak',
                'lainnya',
            ])->default('kepala_keluarga');
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
