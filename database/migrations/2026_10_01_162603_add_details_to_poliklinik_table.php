<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('poliklinik', function (Blueprint $table) {
            $table->string('deskripsi')->nullable()->after('nama_poli');
            $table->boolean('status_aktif')->default(true)->after('deskripsi');
        });
    }

    public function down(): void
    {
        Schema::table('poliklinik', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'status_aktif']);
        });
    }
};
