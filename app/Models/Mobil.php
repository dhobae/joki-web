<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mobil extends Model
{
    use HasFactory;

    protected $table = 'mobil';
    protected $guarded = ['id'];

    public function merk()
    {
        return $this->belongsTo(Merk::class, 'id_merk');
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'id_jenis');
    }

    // public function peminjamans()
    // {
    //     return $this->hasMany(Peminjaman::class, 'id_mobil');
    // }
}
