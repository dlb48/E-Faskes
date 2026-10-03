<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('id_penjamin')->nullable()->after('jenis_pasien');
            $table->foreign('id_penjamin')->references('id_penjamin')->on('penjamins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropForeign(['id_penjamin']);
            $table->dropColumn('id_penjamin');
        });
    }
};

