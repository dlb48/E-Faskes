<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('nama_penanggung_jawab')->nullable()->after('no_telepon');
            $table->string('hubungan_penanggung_jawab')->nullable()->after('nama_penanggung_jawab');
            $table->text('alamat_penanggung_jawab')->nullable()->after('hubungan_penanggung_jawab');
            $table->string('no_telepon_penanggung_jawab')->nullable()->after('alamat_penanggung_jawab');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn([
                'nama_penanggung_jawab',
                'hubungan_penanggung_jawab',
                'alamat_penanggung_jawab',
                'no_telepon_penanggung_jawab'
            ]);
        });
    }
};
