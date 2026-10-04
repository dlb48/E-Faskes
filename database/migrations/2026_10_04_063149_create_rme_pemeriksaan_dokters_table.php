<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rme_pemeriksaan_dokter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftaran_id');
            // Anamnesa
            $table->text('keluhan_utama')->nullable();
            $table->text('riwayat_penyakit_sekarang')->nullable();
            $table->text('riwayat_alergi')->nullable();
            $table->string('kesadaran')->nullable();
            
            // Diagnosa
            $table->string('kode_icd10')->nullable();
            $table->string('nama_diagnosa')->nullable();
            $table->text('keterangan_diagnosa')->nullable();
            $table->timestamps();

            $table->foreign('pendaftaran_id')->references('id')->on('pendaftaran')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rme_pemeriksaan_dokter');
    }
};
