<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rme_pemeriksaan_dokter', function (Blueprint $table) {
            $table->text('riwayat_penyakit_dahulu')->nullable()->after('riwayat_penyakit_sekarang');
            $table->text('pemeriksaan_fisik')->nullable()->after('kesadaran');
            
            $table->string('status_kasus', 50)->nullable()->after('keterangan_diagnosa'); // Kasus Baru / Kasus Lama
            
            $table->string('kode_icd10_sekunder')->nullable()->after('status_kasus');
            $table->string('nama_diagnosa_sekunder')->nullable()->after('kode_icd10_sekunder');
        });
    }

    public function down(): void
    {
        Schema::table('rme_pemeriksaan_dokter', function (Blueprint $table) {
            $table->dropColumn(['riwayat_penyakit_dahulu', 'pemeriksaan_fisik', 'status_kasus', 'kode_icd10_sekunder', 'nama_diagnosa_sekunder']);
        });
    }
};
