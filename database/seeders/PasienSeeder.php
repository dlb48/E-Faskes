<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pasien;
use Faker\Factory as Faker;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 20; $i++) {
            $jenis_pasien = $faker->randomElement(['Umum', 'BPJS']);
            
            $next_id = Pasien::count() + 1;

            Pasien::create([
                'no_rm' => 'RM-' . date('ym') . '-' . str_pad($next_id, 4, '0', STR_PAD_LEFT),
                'jenis_pasien' => $jenis_pasien,
                'nik' => $faker->numerify('################'), // 16 digits
                'no_kartu_bpjs' => $jenis_pasien == 'BPJS' ? $faker->numerify('#############') : null, // 13 digits
                'nama' => $faker->name,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '-20 years'),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'golongan_darah' => $faker->randomElement(['A', 'B', 'AB', 'O', 'Tidak Tahu']),
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                'status_pernikahan' => $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup']),
                'kewarganegaraan' => 'WNI',
                'nama_ibu_kandung' => $faker->name('female'),
                'pendidikan' => $faker->randomElement(['SMA', 'D3', 'S1', 'SMP']),
                'pekerjaan' => $faker->jobTitle,
                'alamat' => $faker->streetAddress,
                'provinsi' => 'JAWA TIMUR',
                'kabupaten' => $faker->randomElement(['KOTA SURABAYA', 'KABUPATEN SIDOARJO', 'KOTA MALANG']),
                'kecamatan' => $faker->citySuffix,
                'desa' => $faker->streetName,
                'rt' => $faker->numerify('00#'),
                'rw' => $faker->numerify('00#'),
                'kode_pos' => $faker->postcode,
                'no_telepon' => $faker->phoneNumber,
                'nama_penanggung_jawab' => $faker->name,
                'hubungan_penanggung_jawab' => $faker->randomElement(['Suami', 'Istri', 'Ayah', 'Ibu', 'Saudara']),
                'alamat_penanggung_jawab' => $faker->address,
                'no_telepon_penanggung_jawab' => $faker->phoneNumber
            ]);
        }
    }
}
