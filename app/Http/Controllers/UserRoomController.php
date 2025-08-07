<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class UserRoomController extends Controller
{
    public function index()
    {
        return $rooms = Room::where('is_active', True)->get();
    }
}
