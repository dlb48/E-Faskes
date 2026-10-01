<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poliklinik extends Model
{
    use HasFactory;

    protected $table = 'poliklinik';
    protected $guarded = ['id'];

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
