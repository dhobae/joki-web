<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        User::create([
            'name' => 'Karyawan',
            'email' => 'karyawan@gmail.com',
            'no_telp' => '08579902422',
            'divisi' => 'Peminjam',
            'peran' => 'karyawan',
            'foto' => 'none',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        DB::table('merk')->insert([
            ['nama_merk' => 'Toyota'],
            ['nama_merk' => 'Honda'],
            ['nama_merk' => 'Suzuki'],
        ]);

        DB::table('jenis')->insert([
            ['nama_jenis' => 'Manual'],
            ['nama_jenis' => 'Automatic'],
        ]);

        DB::table('mobil')->insert([
            [
                'plat_mobil' => 'B1234ABC',
                'id_merk' => 1, // Toyota
                'id_jenis' => 1, // Manual
                'model' => 'Avanza G 1.3',
                'kapasitas' => 7,
                'status_mobil' => 'Tersedia',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'plat_mobil' => 'B5678DEF',
                'id_merk' => 2, // Honda
                'id_jenis' => 2, // Automatic
                'model' => 'Jazz RS',
                'kapasitas' => 5,
                'status_mobil' => 'Tersedia',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'plat_mobil' => 'B2345HIJ',
                'id_merk' => 3, // Suzuki
                'id_jenis' => 1, // Manual
                'model' => 'Ertiga GL',
                'kapasitas' => 7,
                'status_mobil' => 'Tersedia',
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'plat_mobil' => 'B8765XYZ',
                'id_merk' => 1,
                'id_jenis' => 2,
                'model' => 'Toyota Innova Zenix',
                'kapasitas' => 7,
                'status_mobil' => 'Tersedia',
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        for ($i = 1; $i <= 10; $i++) {
            DB::table('peminjaman')->insert([
                'id_user' => 2,
                'id_mobil' => rand(1, 4),
                'tanggal_pinjam' => now()->subDays(rand(1, 20)),
                'tanggal_pengembalian' => rand(0, 1) ? now()->subDays(rand(0, 1)) : null,
                'status_peminjaman' => collect(['diajukan', 'disetujui', 'digunakan', 'dikembalikan', 'ditolak'])->random(),
                'bukti_pengembalian' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
