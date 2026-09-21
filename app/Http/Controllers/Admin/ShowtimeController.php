<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\Film;
use App\Models\Studio;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $showtimes = Showtime::with(['film', 'studio'])->latest()->paginate(10);
        return view('admin.showtime.index', compact('showtimes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $films = Film::all();
        $studios = Studio::all();
        return view('admin.showtime.create', compact('films', 'studios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'film_id' => 'required|exists:films,id',
            'studio_id' => 'required|exists:studios,id',
            'date' => 'required|date',
            'time' => 'required',
            'price' => 'required|numeric|min:0',
        ],
        [
            'film_id' => 'Film',
            'studio_id' => 'Studio',
            'date' => 'Tanggal Tayang',
            'time' => 'Jam Tayang',
            'price' => 'Harga Tiket',
        ]);

        Showtime::create($validated);
        return redirect()->route('admin.showtime.index')->with('success', 'Jadwal tayang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Showtime $showtime)
    {
        return view('admin.showtime.show', compact('showtime'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Showtime $showtime)
    {
        $films = Film::all();
        $studios = Studio::all();
        return view('admin.showtime.edit', compact('showtime', 'films', 'studios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $showtime = Showtime::findOrFail($id);

        $validated = $request->validate([
            'film_id' => 'required|exists:films,id',
            'studio_id' => 'required|exists:studios,id',
            'date' => 'required|date',
            'time' => 'required',
            'price' => 'required|numeric|min:0',
        ],
        [
            'film_id' => 'Film',
            'studio_id' => 'Studio',
            'date' => 'Tanggal Tayang',
            'time' => 'Jam Tayang',
            'price' => 'Harga Tiket',
        ]);

        $showtime->update($validated);

        return redirect()->route('admin.showtime.index')->with('success', 'Jadwal tayang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $showtime = Showtime::findOrFail($id);
        $showtime->delete();

        return redirect()->route('admin.showtime.index')->with('success', 'Jadwal tayang berhasil dihapus.');
    }
}