<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmePemeriksaanDokter extends Model
{
    use HasFactory;
    
    protected $table = 'rme_pemeriksaan_dokter';

    protected $fillable = [
        'pendaftaran_id',
        'tanggal',
        'keluhan_utama',
        'riwayat_penyakit_sekarang',
        'riwayat_penyakit_dahulu',
        'riwayat_alergi',
        'kesadaran',
        'pemeriksaan_fisik',
        'status_kasus',
        'kode_icd10',
        'nama_diagnosa',
        'kode_icd10_sekunder',
        'nama_diagnosa_sekunder',
        'keterangan_diagnosa'
    ];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }
}
