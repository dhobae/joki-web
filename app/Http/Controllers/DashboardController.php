<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get current month and year from request or use current date
        $currentMonth = $request->get('month', Carbon::now()->month);
        $currentYear = $request->get('year', Carbon::now()->year);

        // Create carbon instance for the selected month
        $currentDate = Carbon::create($currentYear, $currentMonth, 1);

        // Get start and end of month
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        // Get all rooms
        $rooms = Room::where('is_active', true)->get();

        // Get bookings for the current month with related data
        $bookings = Booking::with(['user', 'room'])
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
                    ->orWhereBetween('checkout_date', [$startOfMonth, $endOfMonth])
                    ->orWhere(function ($q) use ($startOfMonth, $endOfMonth) {
                        $q->where('checkin_date', '<=', $startOfMonth)
                            ->where('checkout_date', '>=', $endOfMonth);
                    });
            })
            ->get();

        // Process bookings into calendar format
        $calendarData = $this->processBookingsForCalendar($bookings, $startOfMonth, $endOfMonth);

        // Get statistics
        $stats = $this->getDashboardStats($currentDate);

        // Generate calendar structure
        $calendar = $this->generateCalendarStructure($currentDate, $calendarData);

        return view('user.dashboard', [
            'calendar' => $calendar,
            'currentDate' => $currentDate,
            'bookings' => $bookings,
            'rooms' => $rooms,
            'stats' => $stats,
            'calendarData' => $calendarData
        ]);
    }

    private function getBookingDates($booking, $startOfMonth, $endOfMonth)
    {
        $dates = [];
        $checkinDate = Carbon::parse($booking->checkin_date);
        $checkoutDate = Carbon::parse($booking->checkout_date);

        // If no repeat, just get the date range
        if ($booking->repeat_schedule === 'none') {
            $current = $checkinDate->copy();
            while ($current->lte($checkoutDate) && $current->lte($endOfMonth)) {
                if ($current->gte($startOfMonth)) {
                    $dates[] = $current->copy();
                }
                $current->addDay();
            }
            return $dates;
        }

        // Handle repeat schedules
        $current = $checkinDate->copy();
        $duration = $checkinDate->diffInDays($checkoutDate);

        while ($current->lte($endOfMonth)) {
            if ($current->gte($startOfMonth)) {
                // Add all days in the booking duration
                for ($i = 0; $i <= $duration; $i++) {
                    $bookingDate = $current->copy()->addDays($i);
                    if ($bookingDate->lte($endOfMonth) && $bookingDate->gte($startOfMonth)) {
                        $dates[] = $bookingDate;
                    }
                }
            }

            // Move to next occurrence based on repeat schedule
            switch ($booking->repeat_schedule) {
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
            if ($current->year > $endOfMonth->year + 1) {
                break;
            }
        }

        return $dates;
    }

    private function processBookingsForCalendar($bookings, $startOfMonth, $endOfMonth)
    {
        $calendarData = [];

        foreach ($bookings as $booking) {
            $checkinDate = Carbon::parse($booking->checkin_date);
            $checkoutDate = Carbon::parse($booking->checkout_date);

            // Handle repeat schedules
            $dates = $this->getBookingDates($booking, $startOfMonth, $endOfMonth);

            foreach ($dates as $date) {
                $dateString = $date->format('Y-m-d');

                if (!isset($calendarData[$dateString])) {
                    $calendarData[$dateString] = [];
                }

                $calendarData[$dateString][] = [
                    'id' => $booking->id,
                    'title' => $booking->title,
                    'room_name' => $booking->room->name,
                    'user_name' => $booking->user->name,
                    'checkin_date' => $booking->checkin_date,
                    'checkout_date' => $booking->checkout_date,
                    'status' => $booking->status,
                    'confirmation_status' => $booking->confirmation_status,
                    'type' => $booking->type,
                    'fullday' => $booking->fullday,
                    'person_number' => $booking->person_number,
                    'is_start' => $date->format('Y-m-d') === $checkinDate->format('Y-m-d'),
                    'is_end' => $date->format('Y-m-d') === $checkoutDate->format('Y-m-d'),
                ];
            }
        }

        return $calendarData;
    }

    private function generateCalendarStructure($currentDate, $calendarData)
    {
        $calendar = [];
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        // Get the first day of the week for the month
        $startOfCalendar = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $endOfCalendar = $endOfMonth->copy()->endOfWeek(Carbon::SUNDAY);

        $current = $startOfCalendar->copy();
        $weekNumber = 0;

        while ($current->lte($endOfCalendar)) {
            if ($current->dayOfWeek === Carbon::MONDAY) {
                $weekNumber++;
                $calendar[$weekNumber] = [];
            }

            $dateString = $current->format('Y-m-d');
            $calendar[$weekNumber][] = [
                'date' => $current->copy(),
                'day' => $current->day,
                'is_current_month' => $current->month === $currentDate->month,
                'is_today' => $current->isToday(),
                'bookings' => $calendarData[$dateString] ?? []
            ];

            $current->addDay();
        }

        return $calendar;
    }

    private function getDashboardStats($currentDate)
    {
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();
        $now = Carbon::now();

        // Query booking bulan ini dengan kondisi yang sama seperti di method index
        $bookingsThisMonth = Booking::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('checkin_date', [$startOfMonth, $endOfMonth])
                ->orWhereBetween('checkout_date', [$startOfMonth, $endOfMonth])
                ->orWhere(function ($q) use ($startOfMonth, $endOfMonth) {
                    $q->where('checkin_date', '<=', $startOfMonth)
                        ->where('checkout_date', '>=', $endOfMonth);
                });
        })->count();

        // Get user's active bookings (room yang sedang dibooking oleh user login)
        $userActiveRooms = 0;
        if (auth()->check()) {
            $userActiveRooms = Booking::where('user_id', auth()->id())
                ->where('checkin_date', '<=', $now)
                ->where('checkout_date', '>=', $now)
                ->whereIn('status', ['pending', 'confirmed', 'used']) // Status aktif
                ->whereNotIn('status', ['done', 'canceled']) // Exclude status selesai
                ->distinct('room_id')
                ->count('room_id');
        }

        return [
            'total_bookings_this_month' => $bookingsThisMonth,
            'total_bookings' => $bookingsThisMonth, // Gunakan nilai yang sama
            'all_time_bookings' => Booking::count(), // Total semua booking
            'user_active_rooms' => $userActiveRooms, // Room yang sedang dibooking user
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('confirmation_status', 'confirmed')->count(),
            'tentative_bookings' => Booking::where('confirmation_status', 'tentative')->count(),
            'total_rooms' => Room::where('is_active', true)->count(),
            'total_users' => User::count(),
            'bookings_by_status' => [
                'pending' => Booking::where('status', 'pending')->count(),
                'used' => Booking::where('status', 'used')->count(),
                'done' => Booking::where('status', 'done')->count(),
                'canceled' => Booking::where('status', 'canceled')->count(),
            ],
            'bookings_by_type' => [
                'internal' => Booking::where('type', 'internal')->count(),
                'eksternal' => Booking::where('type', 'eksternal')->count(),
            ]
        ];
    }
}