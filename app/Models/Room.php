<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'facilities',
        'photo',
        'is_active',
    ];

    protected $table = 'rooms';

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi: satu ruangan bisa memiliki banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
