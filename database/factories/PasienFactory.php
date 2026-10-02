<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $counter = 1;
        $no_rm = 'RM-' . date('ym') . '-' . str_pad($counter++, 4, '0', STR_PAD_LEFT);
        
        $jenis_kelamin = $this->faker->randomElement(['Laki-laki', 'Perempuan']);
        $jenis_pasien = $this->faker->randomElement(['Umum', 'BPJS']);
        
        return [
            'no_rm' => $no_rm,
            'nik' => $this->faker->numerify('################'), // 16 digits
            'jenis_pasien' => $jenis_pasien,
            'no_kartu_bpjs' => $jenis_pasien == 'BPJS' ? $this->faker->numerify('#############') : null,
            'nama' => $this->faker->name($jenis_kelamin == 'Laki-laki' ? 'male' : 'female'),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2010-01-01'),
            'jenis_kelamin' => $jenis_kelamin,
            'golongan_darah' => $this->faker->randomElement(['A', 'B', 'AB', 'O', 'Tidak Tahu']),
            'agama' => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']),
            'status_pernikahan' => $this->faker->randomElement(['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati']),
            'kewarganegaraan' => 'WNI',
            'pekerjaan' => $this->faker->jobTitle(),
            'alamat' => $this->faker->streetAddress(),
            'provinsi' => 'Jawa Barat',
            'kabupaten' => $this->faker->city(),
            'kecamatan' => 'Kecamatan ' . $this->faker->word(),
            'desa' => 'Desa ' . $this->faker->word(),
            'no_telepon' => $this->faker->phoneNumber(),
        ];
    }
}
