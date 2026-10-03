<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalDokter extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }

    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'poliklinik_id', 'kode_poli');
    }

    public function getNamaHariAttribute()
    {
        $hari = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu'
        ];
        return $hari[$this->hari] ?? 'Tidak Diketahui';
    }
}
