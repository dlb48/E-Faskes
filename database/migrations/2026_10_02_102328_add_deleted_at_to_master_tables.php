<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pasien', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('pegawai', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('dokters', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('perawats', function (Blueprint $table) { $table->softDeletes(); });
        Schema::table('poliklinik', function (Blueprint $table) { $table->softDeletes(); });
    }

    public function down()
    {
        Schema::table('pasien', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('pegawai', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('dokters', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('perawats', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('poliklinik', function (Blueprint $table) { $table->dropSoftDeletes(); });
    }
};
