<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dokters', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->dropForeign(['poliklinik_id']);
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('restrict');
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('restrict');
        });

        Schema::table('perawats', function (Blueprint $table) {
            $table->dropForeign(['nip']);
            $table->dropForeign(['poliklinik_id']);
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('restrict');
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('restrict');
        });
    }

    public function down()
    {
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
    }
};
