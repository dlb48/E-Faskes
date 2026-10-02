<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('nik_pasien', 16);
            $table->foreign('nik_pasien')->references('nik')->on('pasien')->onDelete('cascade');
            $table->string('kode_poli');
            $table->foreign('kode_poli')->references('kode_poli')->on('poliklinik')->onDelete('cascade');
            $table->string('no_antrean');
            $table->enum('jenis_pasien', ['Umum', 'BPJS']);
            $table->enum('sumber_daftar', ['On-Site', 'Mobile JKN']);
            $table->string('kode_booking')->nullable();
            $table->enum('status', ['Menunggu', 'Diperiksa', 'Selesai', 'Batal'])->default('Menunggu');
            $table->date('tanggal_periksa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
