<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelompok;
use App\Models\User;
use App\Models\Padukuhan;


class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function tampil($padukuhan_id)
    {
        $kelompoks = Kelompok::with(['padukuhan.daftarKkn'])->where('padukuhan_id', $padukuhan_id)->get();

        // return response()->json($kelompoks);

        // dd($kelompoks);

       // Ambil ID siswa yang sudah ada di tabel kelompok
        $padukuhanIdsInKelompok = Kelompok::pluck('padukuhan_id')->toArray();


        $siswa = User::where('type', 0)
            ->where('exist_group', 0)
            ->get();

        $padukuhan = Padukuhan::
            whereNotIn('id', $padukuhanIdsInKelompok)
            ->get();

        return view('pages/admin/kelompok',compact('kelompoks','siswa','padukuhan'));
    }


    public function searchSiswa(Request $request)
{
    $query = $request->get('query'); // Mengambil kata kunci pencarian dari request

    // Jika ada kata kunci, cari siswa berdasarkan kata kunci
     // Ambil ID anggota yang sudah ada di kelompok dari database
     $siswaIdsInKelompok = Kelompok::pluck('anggota')->toArray();


     // Pisahkan ID anggota menjadi array
     $siswaIdsInKelompok = explode(',', implode(',', $siswaIdsInKelompok));


    if ($query) {
        $siswa = User::where('type', 0)
        ->where('name', 'LIKE', "%{$query}%")
        ->where('exist_group', 0)
        ->get();
    }
    // Jika tidak ada kata kunci, ambil semua data siswa
    else {
        $siswa = User::where('type', 0)->where('exist_group', 0)->get();
    }


    return response()->json($siswa);
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
    public function tambahKelompok(Request $request)
    {

        // dd($request->all());
         // Validate the incoming request data
        //  $request->validate([
        //     'nama_kelompok' => 'nullable|string|max:255',
        //     'padukuhan_id' => 'required|exists:padukuhans,id',
        //     'tema' => 'nullable|string|max:255',
        //     'ketua_id' => 'required|exists:users,id|unique:kelompoks,ketua_id',
        //     'anggota' => 'nullable|json',
        //     'tanggal_mulai' => 'required|date',
        //     'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        //     'status' => 'nullable|string|max:255',
        // ]);

        $user = User::find($request->ketua_id);
        $user->exist_group = 1;
        $user->save();

        $anggota = explode(',', $request->selected_ids);
        $anggota = array_filter($anggota);
        foreach ($anggota as $anggota_id) {
            $user = User::find($anggota_id);
            $user->exist_group = 1;
            $user->save();
        }

        // Create the kelompok
        Kelompok::create([
            'nama_kelompok' => $request->nama_kelompok,
            'padukuhan_id' => $request->padukuhan_id,
            'ketua_id' => $request->ketua_id,
            'anggota' => json_encode($request->selected_ids),
            'tanggal_mulai' => $request->start_date,
            'tanggal_selesai' => $request->end_date,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect('kelompok')->with('success', 'Kelompok created successfully.');
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
