<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->string('foto')->nullable();
            $table->enum('tipe', ['berita', 'pengumuman', 'agenda'])->default('berita');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('user_id')->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->timestamps();

            $table->index(['tipe', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
