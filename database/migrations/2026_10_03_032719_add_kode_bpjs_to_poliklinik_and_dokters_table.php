<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('poliklinik', function (Blueprint $table) {
            $table->string('kode_bpjs')->nullable()->after('nama_poli');
        });

        Schema::table('dokters', function (Blueprint $table) {
            $table->string('kode_bpjs')->nullable()->after('poliklinik_id');
        });
    }

    public function down(): void
    {
        Schema::table('poliklinik', function (Blueprint $table) {
            $table->dropColumn('kode_bpjs');
        });

        Schema::table('dokters', function (Blueprint $table) {
            $table->dropColumn('kode_bpjs');
        });
    }
};

