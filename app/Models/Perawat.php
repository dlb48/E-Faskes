<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perawat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'perawats';
    protected $primaryKey = 'id_perawat';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_perawat',
        'nip',
        'poliklinik_id',
        'no_str',
        'masa_berlaku_str',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'nip', 'nip');
    }

    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'poliklinik_id', 'kode_poli');
    }
}
