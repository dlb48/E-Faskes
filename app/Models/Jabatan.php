<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_jabatan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_jabatan',
        'nama_jabatan',
        'deskripsi',
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_jabatan', 'id_jabatan');
    }
}
