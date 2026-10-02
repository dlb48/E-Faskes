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
        Schema::create('perawats', function (Blueprint $table) {
            $table->string('id_perawat')->primary(); // Kode perawat sebagai Primary Key
            $table->string('nip'); // Foreign key ke tabel pegawai
            $table->string('poliklinik_id')->nullable(); // Foreign key ke tabel poliklinik
            $table->date('masa_berlaku_str')->nullable(); // SIPP/STR Perawat
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('pegawai')->onDelete('cascade');
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perawats');
    }
};
