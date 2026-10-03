<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pasien';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function penjamin()
    {
        return $this->belongsTo(Penjamin::class, 'id_penjamin', 'id_penjamin');
    }
}

