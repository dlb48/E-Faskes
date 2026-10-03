<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Penjamin;

class PenjaminSeeder extends Seeder
{
    public function run()
    {
        Penjamin::create([
            'id_penjamin' => 'UMM',
            'nama_penjamin' => 'Umum / Pribadi',
            'deskripsi' => 'Pasien membayar biaya secara mandiri tanpa penjamin asuransi.'
        ]);
        Penjamin::create([
            'id_penjamin' => 'BPJS',
            'nama_penjamin' => 'BPJS Kesehatan',
            'deskripsi' => 'Pasien menggunakan layanan jaminan kesehatan BPJS.'
        ]);
    }
}
