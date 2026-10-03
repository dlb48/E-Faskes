<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan_bpjs', function (Blueprint $table) {
            $table->id();
            $table->string('cons_id')->nullable();
            $table->string('secret_key')->nullable();
            $table->string('user_key')->nullable();
            $table->string('kode_ppk')->nullable();
            $table->boolean('is_production')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_bpjs');
    }
};
