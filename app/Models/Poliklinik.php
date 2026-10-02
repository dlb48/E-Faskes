<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poliklinik extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'poliklinik';
    protected $primaryKey = 'kode_poli';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
