<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Monolog\Handler\RollbarHandler;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'no_telp' => '08579902422',
        'divisi' => 'Pengawas',
        'peran' => 'admin',
        'foto' => 'none',
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
       ]);
    }
}
