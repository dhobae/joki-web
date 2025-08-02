<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard untuk superadmin
Route::get('/superadmin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:super_admin'])->name('superadmin.dashboard');

// super admin / admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin|super_admin'])->name('admin.')->group(function () {

    // Dashboard admin - langsung return view
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Manajemen Ruangan
    Route::resource('/rooms', RoomController::class);

    // Manajemen Booking
    Route::resource('/bookings', BookingController::class);

});


// all role routes
// Dashboard untuk user
// Route::get('/user/dashboard', function () {
//     return view('user.dashboard');
// })->middleware(['auth', 'role:super_admin|admin|user'])->name('user.dashboard');
