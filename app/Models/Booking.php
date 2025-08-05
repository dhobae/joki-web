<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    // Scope untuk booking yang aktif
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'used']);
    }

    // Scope untuk booking yang sudah dikonfirmasi
    public function scopeConfirmed($query)
    {
        return $query->where('confirmation_status', 'confirmed');
    }

    // Accessor untuk durasi booking dalam hari
    public function getDurationInDaysAttribute()
    {
        return $this->checkin_date->diffInDays($this->checkout_date) + 1;
    }

    // Accessor untuk status warna (untuk UI)
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'used' => 'blue',
            'done' => 'green',
            'canceled' => 'red',
            default => 'gray'
        };
    }

    // Accessor untuk confirmation status warna
    public function getConfirmationColorAttribute()
    {
        return match ($this->confirmation_status) {
            'tentative' => 'orange',
            'confirmed' => 'green',
            default => 'gray'
        };
    }

    // Method untuk cek apakah booking bentrok dengan booking lain
    public function hasConflict($roomId, $checkinDate, $checkoutDate, $excludeId = null)
    {
        $query = self::where('room_id', $roomId)
            ->where('status', '!=', 'canceled')
            ->where(function ($q) use ($checkinDate, $checkoutDate) {
                $q->whereBetween('checkin_date', [$checkinDate, $checkoutDate])
                    ->orWhereBetween('checkout_date', [$checkinDate, $checkoutDate])
                    ->orWhere(function ($sq) use ($checkinDate, $checkoutDate) {
                        $sq->where('checkin_date', '<=', $checkinDate)
                            ->where('checkout_date', '>=', $checkoutDate);
                    });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    // Method untuk mendapatkan semua tanggal booking (termasuk repeat)
    public function getAllBookingDates($startDate = null, $endDate = null)
    {
        $dates = [];
        $checkinDate = Carbon::parse($this->checkin_date);
        $checkoutDate = Carbon::parse($this->checkout_date);

        if (!$startDate)
            $startDate = $checkinDate;
        if (!$endDate)
            $endDate = $checkoutDate;

        // Jika tidak ada repeat, return range tanggal biasa
        if ($this->repeat_schedule === 'none') {
            $current = $checkinDate->copy();
            while ($current->lte($checkoutDate)) {
                if ($current->between($startDate, $endDate)) {
                    $dates[] = $current->copy();
                }
                $current->addDay();
            }
            return $dates;
        }

        // Handle repeat schedules
        $current = $checkinDate->copy();
        $duration = $checkinDate->diffInDays($checkoutDate);

        while ($current->lte($endDate)) {
            if ($current->gte($startDate)) {
                // Add all days in the booking duration
                for ($i = 0; $i <= $duration; $i++) {
                    $bookingDate = $current->copy()->addDays($i);
                    if ($bookingDate->between($startDate, $endDate)) {
                        $dates[] = $bookingDate;
                    }
                }
            }

            // Move to next occurrence
            switch ($this->repeat_schedule) {
                case 'daily':
                    $current->addDay();
                    break;
                case 'weekly':
                    $current->addWeek();
                    break;
                case 'monthly':
                    $current->addMonth();
                    break;
            }

            // Prevent infinite loop
            if ($current->year > $endDate->year + 2) {
                break;
            }
        }

        return $dates;
    }
}
