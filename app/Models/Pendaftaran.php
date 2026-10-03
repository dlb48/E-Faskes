<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $guarded = ['id'];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'nik_pasien', 'nik');
    }

    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'kode_poli', 'kode_poli');
    }

    public function penjamin()
    {
        return $this->belongsTo(Penjamin::class, 'id_penjamin', 'id_penjamin');
    }
}
