<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return view('user.auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'regex:/^(08|628)[0-9]{8,12}$/', 'unique:users,phone'], 
            'password' => ['required', 'confirmed', 'min:8'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $request->phone,
            'password' => $validated['password'],
            'profile_photo' => $photoPath,
        ]);

        Auth::login($user);
        return redirect()->intended(route('home')) ->with('success', 'Registrasi berhasil! Selamat datang di Cinevo, ' . $user->name . '.');
    }
}