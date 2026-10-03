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
        Schema::create('jabatans', function (Blueprint $table) {
            $table->string('id_jabatan', 10)->primary();
            $table->string('nama_jabatan');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert some default data
        \DB::table('jabatans')->insert([
            ['id_jabatan' => 'JBT-001', 'nama_jabatan' => 'Direktur Utama', 'created_at' => now(), 'updated_at' => now()],
            ['id_jabatan' => 'JBT-002', 'nama_jabatan' => 'Kepala Bidang', 'created_at' => now(), 'updated_at' => now()],
            ['id_jabatan' => 'JBT-003', 'nama_jabatan' => 'Kepala Ruangan', 'created_at' => now(), 'updated_at' => now()],
            ['id_jabatan' => 'JBT-004', 'nama_jabatan' => 'Staf Pelaksana', 'created_at' => now(), 'updated_at' => now()],
            ['id_jabatan' => 'JBT-005', 'nama_jabatan' => 'Dokter Spesialis', 'created_at' => now(), 'updated_at' => now()],
            ['id_jabatan' => 'JBT-006', 'nama_jabatan' => 'Dokter Umum', 'created_at' => now(), 'updated_at' => now()],
            ['id_jabatan' => 'JBT-007', 'nama_jabatan' => 'Bidan Pelaksana', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Add id_jabatan to pegawai
        Schema::table('pegawai', function (Blueprint $table) {
            $table->string('id_jabatan', 10)->nullable()->after('id_departemen');
            
            $table->foreign('id_jabatan')
                  ->references('id_jabatan')->on('jabatans')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropForeign(['id_jabatan']);
            $table->dropColumn('id_jabatan');
        });
        
        Schema::dropIfExists('jabatans');
    }
};
