<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Peminjaman extends Model {
    use HasFactory;
    protected $fillable = [
        'id_user', 'id_mobil', 'tanggal_pinjam', 'tanggal_pengembalian',
        'status_peminjaman', 'bukti_pengembalian'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function mobil() {
        return $this->belongsTo(Mobil::class, 'id_mobil');
    }
}
