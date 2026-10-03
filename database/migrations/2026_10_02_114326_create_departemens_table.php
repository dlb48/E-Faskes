<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Create departemens table
        Schema::create('departemens', function (Blueprint $table) {
            $table->string('id_departemen')->primary();
            $table->string('nama_departemen');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Insert static default values
        $defaults = [
            ['id_departemen' => 'DPT-001', 'nama_departemen' => 'Pelayanan Medis', 'created_at' => now(), 'updated_at' => now()],
            ['id_departemen' => 'DPT-002', 'nama_departemen' => 'Keperawatan', 'created_at' => now(), 'updated_at' => now()],
            ['id_departemen' => 'DPT-003', 'nama_departemen' => 'Farmasi & Laboratorium', 'created_at' => now(), 'updated_at' => now()],
            ['id_departemen' => 'DPT-004', 'nama_departemen' => 'Administrasi & Keuangan', 'created_at' => now(), 'updated_at' => now()],
            ['id_departemen' => 'DPT-005', 'nama_departemen' => 'SDM & Umum', 'created_at' => now(), 'updated_at' => now()],
            ['id_departemen' => 'DPT-006', 'nama_departemen' => 'IT & Sistem Informasi', 'created_at' => now(), 'updated_at' => now()],
        ];
        DB::table('departemens')->insert($defaults);

        // 3. Alter pegawai table to use foreign key
        Schema::table('pegawai', function (Blueprint $table) {
            // Drop old string column
            $table->dropColumn('departemen');
            
            // Add new FK column
            $table->string('id_departemen')->nullable()->after('nama_lengkap');
            $table->foreign('id_departemen')->references('id_departemen')->on('departemens')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropForeign(['id_departemen']);
            $table->dropColumn('id_departemen');
            $table->string('departemen')->nullable()->after('nama_lengkap');
        });

        Schema::dropIfExists('departemens');
    }
};
