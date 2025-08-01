<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jenis extends Model
{
    use HasFactory;
    protected $table = 'jenis';
    protected $guarded = ['id'];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'id_jenis');
    }
}