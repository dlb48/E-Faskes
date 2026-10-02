<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_dokter';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'poliklinik_id', 'kode_poli');
    }
}
