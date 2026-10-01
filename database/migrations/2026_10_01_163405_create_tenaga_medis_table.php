<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenaga_medis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tenaga_medis')->unique();
            $table->string('nama_lengkap');
            $table->string('nik', 16)->nullable();
            $table->string('no_sip')->nullable(); // Surat Izin Praktik
            $table->string('profesi'); // Dokter Umum, Dokter Spesialis, Perawat, dll
            $table->string('spesialisasi')->nullable(); // Jika dokter spesialis
            $table->string('no_telepon')->nullable();
            $table->foreignId('poliklinik_id')->nullable()->constrained('poliklinik')->nullOnDelete();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenaga_medis');
    }
};
