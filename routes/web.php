<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\DashboardController;
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
    // Route::get('/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('dashboard');

    // Dashboard admin dengan kalender booking
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // API endpoints untuk dashboard
    Route::get('/booking/{id}/details', [AdminDashboardController::class, 'getBookingDetails'])->name('booking.details');
    Route::patch('/booking/{id}/confirmation', [AdminDashboardController::class, 'updateConfirmationStatus'])->name('booking.confirmation');

    // Manajemen Ruangan
    Route::resource('/rooms', RoomController::class);

    // Manajemen Booking
    Route::resource('/bookings', BookingController::class);
    // lengkapi route yang diperlukan apa lagi
    Route::patch('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::patch('/bookings/{booking}/done', [BookingController::class, 'done'])->name('bookings.done');

});

// all role routes
Route::prefix('user')->middleware(['auth', 'role:user'])->name('user.')->group(function () {
    // Route::get('dashboard', function () {
    //     return view('user.dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Booking routes user
    Route::get('bookings', [UserBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/create', [UserBookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings', [UserBookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking}', [UserBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [UserBookingController::class, 'cancel'])->name('bookings.cancel');

});



