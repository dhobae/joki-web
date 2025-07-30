<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        // Search berdasarkan title atau nama user
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', '!=', 'super admin')->get();
        $rooms = Room::where('is_active', true)->get();

        return view('admin.bookings.create', compact('users', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'checkin_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:checkin_date',
            'person_number' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected,used,done,canceled',
            'repeat_schedule' => 'required|in:none,daily,weekly,monthly',
            'repeat_weekly' => 'nullable|string',
            'repeat_monthly' => 'nullable|string',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'type' => 'required|in:internal,eksternal',
            'fullday' => 'boolean',
            'confirmation_status' => 'required|in:tentative,confirmed',
        ]);

        // Validasi kapasitas ruangan
        $room = Room::find($request->room_id);
        if ($request->person_number > $room->capacity) {
            return back()->withErrors(['person_number' => 'Jumlah orang melebihi kapasitas ruangan (' . $room->capacity . ' orang)'])->withInput();
        }

        // Cek konflik jadwal (hanya untuk booking yang approved atau used)
        $conflict = Booking::where('room_id', $request->room_id)
            ->whereIn('status', ['approved', 'used'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('checkin_date', [$request->checkin_date, $request->checkout_date])
                    ->orWhereBetween('checkout_date', [$request->checkin_date, $request->checkout_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('checkin_date', '<=', $request->checkin_date)
                            ->where('checkout_date', '>=', $request->checkout_date);
                    });
            })->exists();

        if ($conflict) {
            return back()->withErrors(['checkin_date' => 'Ruangan sudah dibooking pada waktu tersebut'])->withInput();
        }

        try {
            DB::beginTransaction();

            $booking = Booking::create([
                'user_id' => $request->user_id,
                'room_id' => $request->room_id,
                'checkin_date' => $request->checkin_date,
                'checkout_date' => $request->checkout_date,
                'person_number' => $request->person_number,
                'status' => $request->status,
                'repeat_schedule' => $request->repeat_schedule,
                'repeat_weekly' => $request->repeat_weekly,
                'repeat_monthly' => $request->repeat_monthly,
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'fullday' => $request->has('fullday'),
                'confirmation_status' => $request->confirmation_status,
            ]);

            DB::commit();

            return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'room']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $users = User::where('role', '!=', 'super admin')->get();
        $rooms = Room::where('is_active', true)->get();

        return view('admin.bookings.edit', compact('booking', 'users', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'checkin_date' => 'required|date',
            'checkout_date' => 'required|date|after:checkin_date',
            'person_number' => 'required|integer|min:1',
            'status' => 'required|in:pending,approved,rejected,used,done,canceled',
            'repeat_schedule' => 'required|in:none,daily,weekly,monthly',
            'repeat_weekly' => 'nullable|string',
            'repeat_monthly' => 'nullable|string',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'type' => 'required|in:internal,eksternal',
            'fullday' => 'boolean',
            'confirmation_status' => 'required|in:tentative,confirmed',
        ]);

        // Validasi kapasitas ruangan
        $room = Room::find($request->room_id);
        if ($request->person_number > $room->capacity) {
            return back()->withErrors(['person_number' => 'Jumlah orang melebihi kapasitas ruangan (' . $room->capacity . ' orang)'])->withInput();
        }

        // Cek konflik jadwal (kecuali booking saat ini, hanya untuk booking yang approved atau used)
        $conflict = Booking::where('room_id', $request->room_id)
            ->where('id', '!=', $booking->id)
            ->whereIn('status', ['approved', 'used'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('checkin_date', [$request->checkin_date, $request->checkout_date])
                    ->orWhereBetween('checkout_date', [$request->checkin_date, $request->checkout_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('checkin_date', '<=', $request->checkin_date)
                            ->where('checkout_date', '>=', $request->checkout_date);
                    });
            })->exists();

        if ($conflict) {
            return back()->withErrors(['checkin_date' => 'Ruangan sudah dibooking pada waktu tersebut'])->withInput();
        }

        try {
            DB::beginTransaction();

            $booking->update([
                'user_id' => $request->user_id,
                'room_id' => $request->room_id,
                'checkin_date' => $request->checkin_date,
                'checkout_date' => $request->checkout_date,
                'person_number' => $request->person_number,
                'status' => $request->status,
                'repeat_schedule' => $request->repeat_schedule,
                'repeat_weekly' => $request->repeat_weekly,
                'repeat_monthly' => $request->repeat_monthly,
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'fullday' => $request->has('fullday'),
                'confirmation_status' => $request->confirmation_status,
            ]);

            DB::commit();

            return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Approve booking
     */
    public function approve(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya booking dengan status pending yang bisa di-approve']);
        }

        try {
            $booking->update([
                'status' => 'approved',
                'confirmation_status' => 'confirmed',
            ]);
            return back()->with('success', 'Booking berhasil di-approve');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan']);
        }
    }

    /**
     * Reject booking
     */
    public function reject(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->withErrors(['error' => 'Hanya booking dengan status pending yang bisa di-reject']);
        }

        try {
            $booking->update(['status' => 'rejected']);
            return back()->with('success', 'Booking berhasil di-reject');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan']);
        }
    }
    public function updateStatus(Request $request, Booking $booking)
    {
        {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected,used,done,canceled',
            ]);

            try {
                $booking->update(['status' => $request->status]);
                return response()->json(['success' => true, 'message' => 'Status berhasil diupdate']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan']);
            }
        }
    }

    /**
     * Update confirmation status
     */
    public function updateConfirmation(Request $request, Booking $booking)
    {
        $request->validate([
            'confirmation_status' => 'required|in:tentative,confirmed',
        ]);

        try {
            $booking->update(['confirmation_status' => $request->confirmation_status]);
            return response()->json(['success' => true, 'message' => 'Status konfirmasi berhasil diupdate']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan']);
        }
    }
}
