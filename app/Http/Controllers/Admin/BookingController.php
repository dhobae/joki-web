<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'room')->latest()->paginate(10);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $rooms = Room::where('is_active', true)->get();
        return view('admin.bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'required',
            'room_id' => 'required|exists:rooms,id',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
        ]);

        $booking->update($request->all());

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted.');
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $rooms = Room::where('is_active', true)->get();

        return view('admin.bookings.create', compact('users', 'rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|max:100',
            'description' => 'required',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
            'person_number' => 'required|integer|min:1',
            'type' => 'required|in:internal,eksternal',
            'status' => 'required|in:pending,used,done,canceled',
            'confirmation_status' => 'required|in:tentative,confirmed',
            'repeat_schedule' => 'nullable|in:none,daily,weekly,monthly',
            'fullday' => 'boolean',
        ]);

        // Cek kapasitas ruangan
        $room = Room::findOrFail($request->room_id);
        if ($request->person_number > $room->capacity) {
            return back()->withErrors(['person_number' => 'Jumlah orang melebihi kapasitas ruangan.'])->withInput();
        }

        Booking::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'title' => $request->title,
            'description' => $request->description,
            'checkin_date' => $request->checkin_date,
            'checkout_date' => $request->checkout_date,
            'person_number' => $request->person_number,
            'type' => $request->type,
            'status' => $request->status,
            'confirmation_status' => $request->confirmation_status,
            'repeat_schedule' => $request->repeat_schedule ?? 'none',
            'repeat_weekly' => $request->repeat_weekly ?? null,
            'repeat_monthly' => $request->repeat_monthly ?? null,
            'fullday' => $request->fullday ?? 0,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibuat.');
    }

    // Optional: Tambahan konfirmasi
    public function confirm(Booking $booking)
    {
        $booking->update([
            'confirmation_status' => 'confirmed',
            'status' => 'used',
        ]);
        return back()->with('success', 'Booking confirmed.');
    }

    public function cancel(Booking $booking)
    {
        $booking->update([
            'confirmation_status' => 'confirmed',
            'status' => 'canceled',
        ]);
        return back()->with('success', 'Booking canceled.');
    }

    public function done(Booking $booking)
    {
        $booking->update([
            'status' => 'done',
        ]);
        return back()->with('success', 'Booking marked as done.');
    }
}
