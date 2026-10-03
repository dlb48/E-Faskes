<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmeResepObat extends Model
{
    use HasFactory;

    protected $table = 'rme_resep_obats';
    protected $guarded = ['id'];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'pemeriksaan_id', 'id');
    }
}
