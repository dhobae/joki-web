<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('is_active', true)->get();
        return view('user.bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|max:100',
            'description' => 'required',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
            'person_number' => 'required|integer|min:1',
            'type' => 'required|in:internal,eksternal',
            'fullday' => 'boolean',
            'type_pemesanan'
        ]);

        $room = Room::findOrFail($request->room_id);
        if ($request->person_number > $room->capacity) {
            return back()->withErrors(['person_number' => 'Jumlah orang melebihi kapasitas ruangan.'])->withInput();
        }

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'title' => $request->title,
            'description' => $request->description,
            'checkin_date' => $request->checkin_date,
            'checkout_date' => $request->checkout_date,
            'person_number' => $request->person_number,
            'type' => $request->type,
            'status' => 'pending',
            'confirmation_status' => 'tentative',
            'repeat_schedule' => 'none',
            'fullday' => $request->fullday ?? 0,
        ]);

        return redirect()->route('user.bookings.index')->with('success', 'Booking berhasil dikirim.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak punya akses ke booking ini.');
        }

        return view('user.bookings.show', compact('booking'));
    }


    public function cancel(Booking $booking)
    {
        $booking->update([
            'confirmation_status' => 'confirmed',
            'status' => 'canceled',
        ]);
        return back()->with('success', 'Booking canceled.');
    }
}
