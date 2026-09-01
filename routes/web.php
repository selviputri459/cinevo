<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\FilmController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'create'])->name('login');
Route::post('/login', [App\Http\Controllers\User\Auth\LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [App\Http\Controllers\User\Auth\LoginController::class, 'destroy'])->name('logout');

Route::get('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'create'])->name('register');
Route::post('/register', [App\Http\Controllers\User\Auth\RegisterController::class, 'store'])->name('register.store');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\User\ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/film/{film}', [App\Http\Controllers\User\FilmController::class, 'show'])->name('film.show');
