<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaans';
    protected $guarded = ['id'];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter', 'id_dokter');
    }

    public function resep()
    {
        return $this->hasMany(RmeResepObat::class, 'pemeriksaan_id', 'id');
    }
}
