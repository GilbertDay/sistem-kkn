<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validate the incoming request data
         $request->validate([
            'nama_kelompok' => 'nullable|string|max:255',
            'padukuhan_id' => 'required|exists:padukuhans,id',
            'tema' => 'nullable|string|max:255',
            'ketua_id' => 'required|exists:users,id|unique:kelompoks,ketua_id',
            'anggota' => 'nullable|json',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|string',
        ]);

        // Create the kelompok
        Kelompok::create($request->all());

        return redirect()->route('kelompoks.index')->with('success', 'Kelompok created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'nama_kelompok' => 'nullable|string|max:255',
            'padukuhan_id' => 'required|exists:padukuhans,id',
            'tema' => 'nullable|string|max:255',
            'ketua_id' => 'required|exists:users,id|unique:kelompoks,ketua_id,' . $kelompok->id,
            'anggota' => 'nullable|json',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|string',
        ]);

        // Update the kelompok
        $kelompok->update($request->all());

        return redirect()->route('kelompoks.index')->with('success', 'Kelompok updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelompok->delete();

        return redirect()->route('kelompoks.index')->with('success', 'Kelompok deleted successfully.');
    }
}
