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

    // Relationship dengan booking yang aktif
    public function activeBookings()
    {
        return $this->hasMany(Booking::class)->whereIn('status', ['pending', 'used']);
    }

    // Scope untuk room yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor untuk photo URL
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-room.jpg');
    }

    // Method untuk cek ketersediaan room
    public function isAvailable($checkinDate, $checkoutDate, $personNumber = 1, $excludeBookingId = null)
    {
        // Cek kapasitas
        if ($personNumber > $this->capacity) {
            return false;
        }

        // Cek konflik dengan booking lain
        $conflictQuery = $this->bookings()
            ->where('status', '!=', 'canceled')
            ->where(function ($q) use ($checkinDate, $checkoutDate) {
                $q->whereBetween('checkin_date', [$checkinDate, $checkoutDate])
                    ->orWhereBetween('checkout_date', [$checkinDate, $checkoutDate])
                    ->orWhere(function ($sq) use ($checkinDate, $checkoutDate) {
                        $sq->where('checkin_date', '<=', $checkinDate)
                            ->where('checkout_date', '>=', $checkoutDate);
                    });
            });

        if ($excludeBookingId) {
            $conflictQuery->where('id', '!=', $excludeBookingId);
        }

        return !$conflictQuery->exists();
    }

    // Method untuk mendapatkan booking pada tanggal tertentu
    public function getBookingsForDate($date)
    {
        return $this->bookings()
            ->where('status', '!=', 'canceled')
            ->where('checkin_date', '<=', $date)
            ->where('checkout_date', '>=', $date)
            ->with('user')
            ->get();
    }

    // Method untuk mendapatkan statistik booking
    public function getBookingStats($startDate = null, $endDate = null)
    {
        $query = $this->bookings();

        if ($startDate && $endDate) {
            $query->whereBetween('checkin_date', [$startDate, $endDate]);
        }

        return [
            'total_bookings' => $query->count(),
            'confirmed_bookings' => $query->where('confirmation_status', 'confirmed')->count(),
            'pending_bookings' => $query->where('status', 'pending')->count(),
            'usage_rate' => $this->calculateUsageRate($startDate, $endDate)
        ];
    }

    // Method untuk menghitung tingkat penggunaan room
    private function calculateUsageRate($startDate, $endDate)
    {
        if (!$startDate || !$endDate) {
            return 0;
        }

        $totalDays = \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1;
        $bookedDays = $this->bookings()
            ->where('status', '!=', 'canceled')
            ->whereBetween('checkin_date', [$startDate, $endDate])
            ->get()
            ->sum(function ($booking) {
                return \Carbon\Carbon::parse($booking->checkin_date)
                    ->diffInDays(\Carbon\Carbon::parse($booking->checkout_date)) + 1;
            });

        return $totalDays > 0 ? round(($bookedDays / $totalDays) * 100, 2) : 0;
    }
}
