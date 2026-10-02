<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokters', function (Blueprint $table) {
            $table->string('id_dokter')->primary(); // Kode Dokter (Input manual misal: D-001)
            $table->string('nip'); // Merujuk ke tabel pegawai
            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade');
            
            $table->string('no_sip'); // Surat Izin Praktik
            $table->date('masa_berlaku_sip')->nullable();
            
            $table->string('poliklinik_id')->nullable();
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokters');
    }
};
