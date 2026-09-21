<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studios = Studio::latest()->paginate(10);
        return view('admin.studio.index', compact('studios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.studio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ],
        [
            'name' => 'Nama Studio',
            'capacity' => 'Jumlah Kursi',
        ]);

        Studio::create($validated);
        return redirect()->route('admin.studio.index')->with('success', 'Data studio berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Studio $studio)
    {
        return view('admin.studio.show', compact('studio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Studio $studio)
    {
        return view('admin.studio.edit', compact('studio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ],
        [
            'name' => 'Nama Studio',
            'capacity' => 'Jumlah Kursi',
        ]);

        $studio->update($validated);

        return redirect()->route('admin.studio.index')->with('success', 'Data studio berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Studio $studio)
    {
        $studio->delete();
        return redirect()->route('admin.studio.index');
    }
}
