<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $fillable = [
        'user_id',
        'room_id',
        'checkin_date',
        'checkout_date',
        'person_number',
        'status',
        'repeat_schedule',
        'repeat_weekly',
        'repeat_monthly',
        'title',
        'description',
        'type',
        'fullday',
        'confirmation_status',
    ];

    protected $casts = [
        'fullday' => 'boolean',
        'checkin_date' => 'datetime',
        'checkout_date' => 'datetime',
    ];

    // Relasi ke pengguna (user yang booking)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke ruangan
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
