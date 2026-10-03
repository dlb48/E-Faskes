<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departemen extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_departemen';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_departemen',
        'nama_departemen',
        'deskripsi'
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id_departemen', 'id_departemen');
    }
}
