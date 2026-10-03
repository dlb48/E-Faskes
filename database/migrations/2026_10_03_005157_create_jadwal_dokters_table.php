<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_dokters', function (Blueprint $table) {
            $table->id();
            $table->string('id_dokter');
            $table->string('poliklinik_id');
            $table->tinyInteger('hari')->comment('1=Senin, 2=Selasa, 3=Rabu, 4=Kamis, 5=Jumat, 6=Sabtu, 7=Minggu');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('kuota')->default(0)->comment('0 = Tanpa Batas Kuota');
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('id_dokter')->references('id_dokter')->on('dokters')->onDelete('cascade');
            $table->foreign('poliklinik_id')->references('kode_poli')->on('poliklinik')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_dokters');
    }
};
