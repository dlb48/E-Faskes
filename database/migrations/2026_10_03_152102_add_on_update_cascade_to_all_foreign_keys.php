<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropForeign(['id_penjamin']);
            $table->foreign('id_penjamin')->references('id_penjamin')->on('penjamins')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropForeign(['id_departemen']);
            $table->dropForeign(['id_jabatan']);
            $table->foreign('id_departemen')->references('id_departemen')->on('departemens')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatans')->onDelete('restrict')->onUpdate('cascade');
        });

        Schema::table('dokters', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->dropForeign(['poliklinik_id']);
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::table('perawats', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->dropForeign(['poliklinik_id']);
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::table('jadwal_dokters', function (Blueprint $table) {
            $table->dropForeign(['id_dokter']);
            $table->dropForeign(['poliklinik_id']);
            $table->foreign('id_dokter')->references('id_dokter')->on('dokters')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropForeign(['nik_pasien']);
            $table->dropForeign(['kode_poli']);
            $table->foreign('nik_pasien')->references('nik')->on('pasien')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kode_poli')->references('kode_poli')->on('poliklinik')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        // Reverse operations (remove onUpdate cascade)
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropForeign(['id_penjamin']);
            $table->foreign('id_penjamin')->references('id_penjamin')->on('penjamins')->onDelete('set null');
        });

        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropForeign(['id_departemen']);
            $table->dropForeign(['id_jabatan']);
            $table->foreign('id_departemen')->references('id_departemen')->on('departemens')->onDelete('restrict');
            $table->foreign('id_jabatan')->references('id_jabatan')->on('jabatans')->onDelete('restrict');
        });

        Schema::table('dokters', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->dropForeign(['poliklinik_id']);
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('set null');
        });

        Schema::table('perawats', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->dropForeign(['poliklinik_id']);
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('set null');
        });

        Schema::table('jadwal_dokters', function (Blueprint $table) {
            $table->dropForeign(['id_dokter']);
            $table->dropForeign(['poliklinik_id']);
            $table->foreign('id_dokter')->references('id_dokter')->on('dokters')->onDelete('cascade');
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('cascade');
        });

        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->dropForeign(['nik_pasien']);
            $table->dropForeign(['kode_poli']);
            $table->foreign('nik_pasien')->references('nik')->on('pasien')->onDelete('cascade');
            $table->foreign('kode_poli')->references('kode_poli')->on('poliklinik')->onDelete('cascade');
        });
    }
};
