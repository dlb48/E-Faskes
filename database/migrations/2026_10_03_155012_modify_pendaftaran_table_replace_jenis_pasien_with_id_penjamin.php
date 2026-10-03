<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add id_penjamin and drop jenis_pasien
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->string('id_penjamin')->nullable()->after('no_antrean');
            $table->foreign('id_penjamin')->references('id_penjamin')->on('penjamins')->onDelete('set null')->onUpdate('cascade');
            $table->dropColumn('jenis_pasien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropForeign(['id_penjamin']);
            $table->dropColumn('id_penjamin');
            $table->enum('jenis_pasien', ['Umum', 'BPJS'])->default('Umum')->after('no_antrean');
        });
    }
};
