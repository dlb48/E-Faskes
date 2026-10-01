<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('nama');
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', 'Tidak Tahu'])->default('Tidak Tahu')->after('jenis_kelamin');
            $table->string('agama')->nullable()->after('golongan_darah');
            $table->string('status_pernikahan')->nullable()->after('agama');
            $table->string('kewarganegaraan')->default('WNI')->after('status_pernikahan');
            $table->string('rt', 5)->nullable()->after('alamat');
            $table->string('rw', 5)->nullable()->after('rt');
            $table->string('kode_pos', 5)->nullable()->after('rw');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'golongan_darah',
                'agama',
                'status_pernikahan',
                'kewarganegaraan',
                'rt',
                'rw',
                'kode_pos'
            ]);
        });
    }
};
