<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = auth('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = auth('admin')->user();
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // unique tapi abaikan email milik admin ini sendiri
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($admin->id)],
            // password boleh kosong (kalau kosong = tidak diganti)
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ], [
            'required' => ':attribute wajib diisi.',
            'email' => 'Format :attribute tidak valid.',
            'unique' => ':attribute sudah dipakai admin lain.',
            'min.string' => ':attribute minimal :min karakter.',
            'confirmed' => 'Konfirmasi password tidak cocok.',
            'image' => ':attribute harus berupa gambar.',
            'mimes' => ':attribute harus berformat JPG atau PNG.',
            'max.string' => ':attribute maksimal :max karakter.',
            'max.file' => ':attribute maksimal :max KB.',
        ], [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
            'profile_photo' => 'Foto profil',
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];

        if ($request->filled('password')) {
            $admin->password = $validated['password'];
        }
        if ($request->hasFile('profile_photo')) {
            // hapus foto lama supaya storage tidak menumpuk
            if ($admin->profile_photo) {
                Storage::disk('public')->delete($admin->profile_photo);
            }
            $admin->profile_photo = $request->file('profile_photo')->store('profile_photo', 'public');
        }
        $admin->save();
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}