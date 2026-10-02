<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poliklinik;

class PoliklinikSeeder extends Seeder
{
    public function run(): void
    {
        $polikliniks = [
            ['kode_poli' => 'P-001', 'nama_poli' => 'Poli Umum'],
            ['kode_poli' => 'P-002', 'nama_poli' => 'Poli Gigi'],
            ['kode_poli' => 'P-003', 'nama_poli' => 'Poli KIA'],
            ['kode_poli' => 'P-004', 'nama_poli' => 'Poli Penyakit Dalam'],
        ];

        foreach ($polikliniks as $poli) {
            Poliklinik::create($poli);
        }
    }
}
