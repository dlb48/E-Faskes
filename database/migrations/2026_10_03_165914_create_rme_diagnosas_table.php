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
        Schema::create('rme_diagnosas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pemeriksaan_id');
            $table->string('kode_icd10')->nullable();
            $table->string('nama_diagnosa');
            $table->enum('jenis_diagnosa', ['Primer', 'Sekunder', 'Komplikasi'])->default('Primer');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('pemeriksaan_id')->references('id')->on('pemeriksaans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rme_diagnosas');
    }
};
