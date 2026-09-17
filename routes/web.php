<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');

Route::get('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'create'])->name('login');
Route::post('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [App\Http\Controllers\User\Auth\LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'create'])->name('register');
Route::post('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'store'])->name('register.store');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/booking/create', [App\Http\Controllers\User\BookingController::class, 'create'])->name('booking.create');
    Route::get('/riwayat-booking', [App\Http\Controllers\User\BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [App\Http\Controllers\User\BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{booking}', [App\Http\Controllers\User\BookingController::class, 'show'])->name('booking.show');
    Route::patch('/booking/{booking}/cancel', [App\Http\Controllers\User\BookingController::class, 'cancel'])->name('booking.cancel');
});

Route::get('/film/{film}', [App\Http\Controllers\User\FilmController::class, 'show'])->name('film.show');
Route::get('/film/{film}/jadwal', [App\Http\Controllers\User\FilmController::class, 'jadwal'])->name('film.jadwal');

Route::get('/showtime/{showtime}/seats', [App\Http\Controllers\User\SeatController::class, 'index'])->middleware('auth')->name('seats.index');

Route::prefix('admin')->name('admin.')->group(function () {
 
    Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'create'])->name('login');
    Route::post('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'store'])->name('login.store');
 
    Route::middleware('auth:admin')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/data-admin', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('data-admin.index');
    Route::get('/data-admin/create', [App\Http\Controllers\Admin\AdminController::class, 'create'])->name('data-admin.create');
    Route::post('/data-admin', [App\Http\Controllers\Admin\AdminController::class, 'store'])->name('data-admin.store');
    Route::delete('/data-admin/{admin}', [App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('data-admin.destroy');
    Route::resource('film', App\Http\Controllers\Admin\FilmController::class);
});
 
});