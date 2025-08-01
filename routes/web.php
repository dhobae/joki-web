<?php

use App\Http\Controllers\Admin\MobilController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\JenisController;
use App\Http\Controllers\Admin\MerkController;
use Illuminate\Support\Facades\Route;

// Route::get("/", function () {
//     return view('components.app');
// })->middleware('auth');


Route::redirect('/', '/login');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'peran:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('mobil', MobilController::class);
    Route::resource('jenis', JenisController::class);
    Route::resource('merk', MerkController::class);
});


// belum diulah
// Dashboard untuk admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'peran:admin'])->name('admin.dashboard');

// Dashboard untuk karyawan
Route::get('/karyawan/dashboard', function () {
    return view('karyawan.dashboard');
})->middleware(['auth', 'peran:admin|karyawan'])->name('karyawan.dashboard');

