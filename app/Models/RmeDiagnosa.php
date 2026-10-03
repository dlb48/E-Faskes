<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeDiagnosa extends Model
{
    use HasFactory;

    protected $table = 'rme_diagnosas';
    protected $guarded = ['id'];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'pemeriksaan_id', 'id');
    }
}
