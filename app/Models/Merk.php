<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merk extends Model
{
    use HasFactory;
    protected $table = 'merk';
    protected $guarded = ['id'];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'id_merk');
    }
}