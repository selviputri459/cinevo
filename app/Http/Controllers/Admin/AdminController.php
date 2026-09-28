<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->paginate(10);
        return view('admin.data-admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.data-admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('profile_photo', 'public');
        }
        Admin::create($validated);
        return redirect()->route('admin.data-admin.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function destroy(Admin $admin)
    {
        // Admin tidak boleh menghapus akunnya sendiri (supaya tidak terkunci dari sistem)
        if ($admin->id === auth('admin')->id()) {
            return redirect()->route('admin.data-admin.index')->with('error', 'Kamu tidak bisa menghapus akun yang sedang dipakai login.');
        }
        if ($admin->profile_photo) {
            Storage::disk('public')->delete($admin->profile_photo);
        }
        $admin->delete();
        return redirect()->route('admin.data-admin.index')->with('success', 'Admin berhasil dihapus.');
    }
}