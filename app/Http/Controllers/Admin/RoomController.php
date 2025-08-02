<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer',
            'facilities' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('rooms', 'public');
            $data['photo'] = $photoPath;
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer',
            'facilities' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($room->photo && Storage::disk('public')->exists($room->photo)) {
                Storage::disk('public')->delete($room->photo);
            }

            $photoPath = $request->file('photo')->store('rooms', 'public');
            $data['photo'] = $photoPath;
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        // Hapus foto dari storage jika ada
        if ($room->photo && Storage::disk('public')->exists($room->photo)) {
            Storage::disk('public')->delete($room->photo);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
