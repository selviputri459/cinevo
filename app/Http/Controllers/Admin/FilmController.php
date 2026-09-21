<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::latest()->paginate(10);
        return view('admin.film.index', compact('films'));
    }

    public function create()
    {
        return view('admin.film.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:1'],
            'synopsis' => ['required', 'string'],
            'poster' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        $validated['poster'] = $request->file('poster')->store('posters', 'public');
        Film::create($validated);
        return redirect()->route('admin.film.index') ->with('success', 'Film berhasil ditambahkan.');
    }

    public function show(Film $film)
    {
        return view('admin.film.show', compact('film'));
    }

    public function edit(Film $film)
    {
        return view('admin.film.edit', compact('film'));
    }

    public function update(Request $request, Film $film)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'integer', 'min:1'],
            'synopsis' => ['required', 'string'],
            'poster' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ]);

        if ($request->hasFile('poster')) {
            if ($film->poster) {
                Storage::disk('public')->delete($film->poster);
            }
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $film->update($validated);
        return redirect()->route('admin.film.index')->with('success', 'Film berhasil diperbarui.');
    }

    public function destroy(Film $film)
    {
        if ($film->poster) {
            Storage::disk('public')->delete($film->poster);
        }

        $film->delete();
        return redirect()->route('admin.film.index')->with('success', 'Film berhasil dihapus.');
    }
}