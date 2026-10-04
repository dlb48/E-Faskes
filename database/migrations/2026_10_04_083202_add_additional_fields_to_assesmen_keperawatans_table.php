<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assesmen_keperawatans', function (Blueprint $table) {
            $table->decimal('lingkar_perut', 5, 2)->nullable()->after('tinggi_badan');
            $table->integer('skala_nyeri')->nullable()->after('lingkar_perut'); // 0 - 10
            $table->string('resiko_jatuh')->nullable()->after('skala_nyeri'); // Tidak Berisiko, Risiko Rendah, Risiko Tinggi
            $table->text('riwayat_alergi')->nullable()->after('resiko_jatuh');
        });
    }

    public function down(): void
    {
        Schema::table('assesmen_keperawatans', function (Blueprint $table) {
            $table->dropColumn(['lingkar_perut', 'skala_nyeri', 'resiko_jatuh', 'riwayat_alergi']);
        });
    }
};
