<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // user seeder
        User::create([
            "name" => "admin1",
            "email" => "superadmin@gmail.com",
            "password" => Hash::make("password"),
            "role" => "super_admin",
        ]);

        User::create([
            "name" => "admin1",
            "email" => "admin@gmail.com",
            "password" => Hash::make("password"),
            "role" => "admin",
        ]);

        User::create([
            "name" => "user1",
            "email" => "user@gmail.com",
            "password" => Hash::make("password"),
            "role" => "user",
        ]);

        // room seeder
        Room::create([
            'name' => 'Meeting Room A',
            'description' => 'Ruang rapat kapasitas sedang',
            'capacity' => 10,
            'facilities' => 'Projector, AC, Whiteboard',
            'photo' => 'meeting_room_a.jpg',
        ]);

        Room::create([
            'name' => 'Conference Hall',
            'description' => 'Ruang besar untuk seminar',
            'capacity' => 100,
            'facilities' => 'Sound System, Stage, Projector',
            'photo' => 'conference_hall.jpg',
        ]);

        // booking seeder
        $user = User::first();
        $room = Room::first();

        Booking::create([
            'user_id' => $user->id,
            'room_id' => $room->id,
            'checkin_date' => Carbon::now()->addDays(1),
            'checkout_date' => Carbon::now()->addDays(1)->addHours(2),
            'person_number' => 5,
            'status' => 'pending',
            'repeat_schedule' => 'none',
            'title' => 'Team Meeting',
            'description' => 'Diskusi proyek bulanan tim',
            'type' => 'internal',
            'fullday' => false,
            'confirmation_status' => 'tentative',
        ]);

    }
}
