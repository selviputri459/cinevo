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
    public function index(Request $request)
    {
        // Tab aktif: 'aktif' (default) atau 'riwayat'
        $tab = $request->get('tab') === 'riwayat' ? 'riwayat' : 'aktif';

        $query = Showtime::with(['film', 'studio']);

        // Pisahkan data sesuai tab
        $tab === 'riwayat' ? $query->past() : $query->upcoming();

        // 1. Search menyeluruh (judul film ATAU nama studio)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('film', function ($f) use ($search) {
                    $f->where('title', 'like', "%{$search}%");
                })->orWhereHas('studio', function ($s) use ($search) {
                    $s->where('name', 'like', "%{$search}%");
                });
            });
        }

        // 2. Filter per film
        if ($request->filled('film_id')) {
            $query->where('film_id', $request->film_id);
        }

        // 3. Filter per studio
        if ($request->filled('studio_id')) {
            $query->where('studio_id', $request->studio_id);
        }

        // 4. Filter per tanggal
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        // 5. Filter rentang jam
        if ($request->filled('time_from')) {
            $query->whereTime('time', '>=', $request->time_from);
        }
        if ($request->filled('time_to')) {
            $query->whereTime('time', '<=', $request->time_to);
        }

        // Urutan: aktif = terdekat dulu (ASC), riwayat = paling baru lewat dulu (DESC)
        $direction = $tab === 'riwayat' ? 'DESC' : 'ASC';
        $showtimes = $query->orderByRaw("TIMESTAMP(`date`, `time`) {$direction}")
            ->paginate(10)
            ->withQueryString();

        $films   = Film::orderBy('title')->get();
        $studios = Studio::orderBy('name')->get();

        // Jumlah untuk badge di tab
        $totalAktif   = Showtime::upcoming()->count();
        $totalRiwayat = Showtime::past()->count();

        return view('admin.showtime.index', compact(
            'showtimes', 'films', 'studios', 'tab', 'totalAktif', 'totalRiwayat'
        ));
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