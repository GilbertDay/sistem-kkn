<?php

namespace App\Http\Controllers;

use App\Models\Padukuhan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePadukuhanRequest;
use App\Http\Requests\UpdatePadukuhanRequest;

class PadukuhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $padukuhans = Padukuhan::with('users')->paginate(10);
        $dosen = User::where('type', 1)->get();

        return view('pages/admin/padukuhan',compact('padukuhans','dosen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function tambahPadukuhan(Request $req)
    {
        // Validate the input data
        $validated = $req->validate([
            'lokasi' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'dukuh' => 'required|string|max:255',
            'apl' => 'nullable|string|max:255', // Optional field
            'dosen_id' => 'nullable|integer|exists:users,id', // Validate that it exists in the 'dosens' table
        ]);

        // Create and save the new Padukuhan to the database
        $padukuhan = new Padukuhan();
        $padukuhan->lokasi = $validated['lokasi'];
        $padukuhan->kecamatan = $validated['kecamatan'];
        $padukuhan->nama_dukuh = $validated['dukuh'];
        $padukuhan->apl = $validated['apl'];
        $padukuhan->dosen_id = $validated['dosen_id'];
        $padukuhan->save();

        // Redirect back with a success message
        return redirect('/padukuhan')->with('success', 'Padukuhan added successfully!');
    }

    public function editPadukuhan(Request $req)
    {
        $validated = $req->validate([
            'lokasi' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'dukuh' => 'required|string|max:255',
            'apl' => 'nullable|string|max:255', // Optional field
            'dosen_id' => 'nullable|integer|exists:users,id', // Validate that it exists in the 'dosens' table
        ]);

        $id = $req->input('id');
        $padukuhan = Padukuhan::find($id);
        $padukuhan->lokasi = $validated['lokasi'];
        $padukuhan->kecamatan = $validated['kecamatan'];
        $padukuhan->nama_dukuh = $validated['dukuh'];
        $padukuhan->apl = $validated['apl'];
        $padukuhan->dosen_id = $validated['dosen_id'];
        $padukuhan->save();
        return redirect('/padukuhan')->with('success', 'Padukuhan updated successfully!');
    }
    public function hapusPadukuhan(Request $req)
    {
        $id = $req->input('id');
        $padukuhan = Padukuhan::find($id);
        $padukuhan->delete();
        return redirect('/padukuhan')->with('success', 'Padukuhan deleted successfully!');

    }

    /**
     * Store a newly created resource in storage.
     */

}
