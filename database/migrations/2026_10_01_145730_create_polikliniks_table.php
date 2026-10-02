<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poliklinik', function (Blueprint $table) {
            $table->string('kode_poli')->primary();
            $table->string('nama_poli');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poliklinik');
    }
};
