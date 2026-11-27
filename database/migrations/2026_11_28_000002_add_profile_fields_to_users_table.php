<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp', 20)->nullable()->after('avatar');
            $table->boolean('is_active')->default(true)->after('no_hp');
            $table->foreignId('rt_id')->nullable()->after('is_active')
                ->constrained('wilayah')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('rt_id');
            $table->dropColumn(['no_hp', 'is_active']);
        });
    }
};
