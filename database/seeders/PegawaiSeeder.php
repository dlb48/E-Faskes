<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $pegawais = [
            [
                'nip' => '198504122010011001',
                'nama_lengkap' => 'dr. Andi Setiawan, Sp.PD',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1985-04-12',
                'alamat' => 'Jl. Merdeka No. 45, Jakarta Selatan',
                'no_telepon' => '081234567890',
                'departemen' => 'Pelayanan Medis',
                'jabatan' => 'Dokter Spesialis Penyakit Dalam',
                'status_karyawan' => 'Tetap',
                'tanggal_bergabung' => '2010-01-15',
                'status_aktif' => true,
            ],
            [
                'nip' => '199008252015022002',
                'nama_lengkap' => 'Siti Aminah, S.Kep., Ners',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1990-08-25',
                'alamat' => 'Jl. Pahlawan No. 12, Bandung',
                'no_telepon' => '081987654321',
                'departemen' => 'Keperawatan',
                'jabatan' => 'Kepala Ruangan Rawat Inap',
                'status_karyawan' => 'Tetap',
                'tanggal_bergabung' => '2015-02-01',
                'status_aktif' => true,
            ],
            [
                'nip' => '199211052018031003',
                'nama_lengkap' => 'Budi Santoso, S.Farm., Apt',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1992-11-05',
                'alamat' => 'Jl. Diponegoro No. 88, Surabaya',
                'no_telepon' => '081345678901',
                'departemen' => 'Farmasi & Laboratorium',
                'jabatan' => 'Apoteker Penanggung Jawab',
                'status_karyawan' => 'Tetap',
                'tanggal_bergabung' => '2018-03-10',
                'status_aktif' => true,
            ],
            [
                'nip' => '199502142020042004',
                'nama_lengkap' => 'Rina Melati, S.E.',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '1995-02-14',
                'alamat' => 'Jl. Sudirman No. 5, Semarang',
                'no_telepon' => '085712345678',
                'departemen' => 'Administrasi & Keuangan',
                'jabatan' => 'Staf Keuangan / Kasir',
                'status_karyawan' => 'Kontrak',
                'tanggal_bergabung' => '2020-04-01',
                'status_aktif' => true,
            ],
            [
                'nip' => '199807302022051005',
                'nama_lengkap' => 'Faisal Rahman, S.Kom.',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1998-07-30',
                'alamat' => 'Jl. Kaliurang Km 5, Yogyakarta',
                'no_telepon' => '081298765432',
                'departemen' => 'IT & Sistem Informasi',
                'jabatan' => 'IT Support',
                'status_karyawan' => 'Kontrak',
                'tanggal_bergabung' => '2022-05-15',
                'status_aktif' => true,
            ],
        ];

        foreach ($pegawais as $pegawai) {
            Pegawai::create($pegawai);
        }
    }
}
