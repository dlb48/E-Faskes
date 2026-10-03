<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjamin extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_penjamin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_penjamin',
        'nama_penjamin',
        'deskripsi',
    ];
}

