<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'room']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan confirmation_status
        if ($request->filled('confirmation_status')) {
            $query->where('confirmation_status', $request->confirmation_status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('checkin_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('checkout_date', '<=', $request->date_to);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('room', function ($roomQuery) use ($search) {
                        $roomQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(perPage: 2);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'room']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function create()
    {
        $users = User::where('role', '!=', 'super_admin')->get();
        $rooms = Room::where('is_active', true)->get();

        return view('admin.bookings.create', compact('users', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'checkin_date' => 'required|date|after_or_equal:now',
            'checkout_date' => 'required|date|after:checkin_date',
            'person_number' => 'required|integer|min:1',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'type' => 'required|in:internal,eksternal',
            'repeat_schedule' => 'nullable|in:none,daily,weekly,monthly',
            'repeat_weekly' => 'nullable|string',
            'repeat_monthly' => 'nullable|string',
            'fullday' => 'boolean',
            'confirmation_status' => 'required|in:tentative,confirmed',
        ]);

        // Check room availability
        $conflictBooking = Booking::where('room_id', $request->room_id)
            ->where('status', '!=', 'canceled')
            ->where(function ($query) use ($request) {
                $query->whereBetween('checkin_date', [$request->checkin_date, $request->checkout_date])
                    ->orWhereBetween('checkout_date', [$request->checkin_date, $request->checkout_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('checkin_date', '<=', $request->checkin_date)
                            ->where('checkout_date', '>=', $request->checkout_date);
                    });
            })->exists();

        if ($conflictBooking) {
            return back()->withErrors(['room_id' => 'Room is not available for the selected time period.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $booking = Booking::create($request->all());

            DB::commit();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to create booking.'])->withInput();
        }
    }

    public function edit(Booking $booking)
    {
        $users = User::where('role', '!=', 'super_admin')->get();
        $rooms = Room::where('is_active', true)->get();

        return view('admin.bookings.edit', compact('booking', 'users', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
            'person_number' => 'required|integer|min:1',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'type' => 'required|in:internal,eksternal',
            'status' => 'required|in:pending,used,done,canceled',
            'repeat_schedule' => 'nullable|in:none,daily,weekly,monthly',
            'repeat_weekly' => 'nullable|string',
            'repeat_monthly' => 'nullable|string',
            'fullday' => 'boolean',
            'confirmation_status' => 'required|in:tentative,confirmed',
        ]);

        // Normalisasi tanggal
        $checkin = Carbon::parse($request->checkin_date)->format('Y-m-d H:i:s');
        $checkout = Carbon::parse($request->checkout_date)->format('Y-m-d H:i:s');

        // Cek konflik dengan booking lain (selain dirinya sendiri)
        $conflictBooking = Booking::where('room_id', $request->room_id)
            ->where('id', '!=', $booking->id)
            ->where('status', '!=', 'canceled')
            ->where(function ($query) use ($checkin, $checkout) {
                $query->where('checkin_date', '<', $checkout)
                    ->where('checkout_date', '>', $checkin);
            })
            ->exists();

        if ($conflictBooking) {
            return back()->withErrors(['room_id' => 'Room is not available for the selected time period.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $booking->update($request->all());

            DB::commit();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update booking.'])->withInput();
        }
    }

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete booking.']);
        }
    }

    public function approve(Booking $booking)
    {
        $booking->update([
            'status' => 'used',
            'confirmation_status' => 'confirmed',
        ]);

        return redirect()->back()->with('success', 'Booking approved successfully.');
    }

    public function reject(Booking $booking)
    {
        $booking->update([
            'status' => 'canceled',
        ]);

        return redirect()->back()->with('success', 'Booking rejected successfully.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,used,done,canceled',
            'confirmation_status' => 'nullable|in:tentative,confirmed',
        ]);

        $updateData = ['status' => $request->status];

        if ($request->filled('confirmation_status')) {
            $updateData['confirmation_status'] = $request->confirmation_status;
        }

        $booking->update($updateData);

        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }
}
