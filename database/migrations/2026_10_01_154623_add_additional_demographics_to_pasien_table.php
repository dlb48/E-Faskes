<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('nama_ibu_kandung')->nullable()->after('kewarganegaraan');
            $table->string('pendidikan')->nullable()->after('nama_ibu_kandung');
            $table->string('pekerjaan')->nullable()->after('pendidikan');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn(['nama_ibu_kandung', 'pendidikan', 'pekerjaan']);
        });
    }
};
