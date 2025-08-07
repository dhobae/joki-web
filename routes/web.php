<?php

use App\Http\Controllers\Admin\JenisController;
use App\Http\Controllers\Admin\MerkController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\Admin\MobilController as AdminMobilController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->peran === 'admin') {
            return redirect('/admin/dashboard');
        } elseif (Auth::user()->peran === 'karyawan') {
            return redirect('/karyawan/dashboard');
        }
    }
    return redirect('/login');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// admin
Route::middleware(['auth', 'peran:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->middleware(['auth', 'peran:admin'])->name('dashboard');

    Route::resource('mobil', AdminMobilController::class);
    Route::resource('jenis', JenisController::class);
    Route::resource('merk', MerkController::class);

    Route::get('peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/{id}/bukti', [AdminPeminjamanController::class, 'lihatBukti'])->name('peminjaman.bukti');

    // sedang dipinjam dan sedang dikembalikan
    Route::get('peminjaman/riwayat-sedang-dipinjam', [AdminPeminjamanController::class, 'sedangDipinjamList'])->name('riwayat-sedang-dipinjam');
    Route::get('peminjaman/riwayat-sudah-dikembalikan', [AdminPeminjamanController::class, 'sudahDikembalikanList'])->name('sudah-dikembalikan');


});

// karyawan
Route::middleware(['auth', 'peran:admin|karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('dashboard', function () {
        return view('karyawan.dashboard');
    })->name('dashboard');

    Route::get('mobil-list', [MobilController::class, 'index'])->name('mobil-list');;

    Route::resource('peminjaman', PeminjamanController::class)->except(['edit', 'update', 'destroy']);
    Route::get('peminjaman/{id}/pengembalian', [PeminjamanController::class, 'pengembalianForm'])->name('peminjaman.pengembalian.form');
    Route::post('peminjaman/{id}/pengembalian', [PeminjamanController::class, 'pengembalianStore'])->name('peminjaman.pengembalian.store');

    // Route::resource('peminjaman/riwayat', PeminjamanController::class)->only(['index','destroy']);

});


