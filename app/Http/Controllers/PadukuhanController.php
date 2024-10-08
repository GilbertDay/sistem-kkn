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
    public function tampil($kkn_id)
    {
        //
        $padukuhans = Padukuhan::with('users')->where('daftar_kkn_id', $kkn_id)->paginate(10);
        $dosen = User::where('type', 1)->get();

        return view('pages/admin/padukuhan',compact('padukuhans','dosen','kkn_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function tambahPadukuhan(Request $req)
    {
        // Validate the input data
        // $validated = $req->validate([
        //     'lokasi' => 'required|string|max:255',
        //     'kkn_id' => 'required',
        //     'desa' => 'required|string|max:255',
        //     'apl' => 'nullable|string|max:255', // Optional field
        //     'dosen_id' => 'nullable|integer|exists:users,id', // Validate that it exists in the 'dosens' table
        // ]);

        // Create and save the new Padukuhan to the database
        $padukuhan = new Padukuhan();
        $padukuhan->daftar_kkn_id = $req->kkn_id;
        $padukuhan->desa = $req->desa;
        $padukuhan->nama_dukuh = $req->dukuh;
        $padukuhan->apl = $req->apl;
        $padukuhan->dosen_id = $req->dosen_id;
        $padukuhan->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Padukuhan added successfully!');
    }

    public function editPadukuhan(Request $req)
    {
        // $validated = $req->validate([
        //     'lokasi' => 'required|string|max:255',
        //     'kecamatan' => 'required|string|max:255',
        //     'dukuh' => 'required|string|max:255',
        //     'apl' => 'nullable|string|max:255', // Optional field
        //     'dosen_id' => 'nullable|integer|exists:users,id', // Validate that it exists in the 'dosens' table
        // ]);

        $id = $req->input('id');
        $padukuhan = Padukuhan::find($id);
        $padukuhan->daftar_kkn_id = $req->kkn_id;
        $padukuhan->desa = $req->desa;
        $padukuhan->nama_dukuh = $req->dukuh;
        $padukuhan->apl = $req->apl;
        $padukuhan->dosen_id = $req->dosen_id;
        $padukuhan->save();
        return redirect()->back()->with('success', 'Padukuhan updated successfully!');
    }
    public function hapusPadukuhan(Request $req)
    {
        $id = $req->input('id');
        $padukuhan = Padukuhan::find($id);
        // dd($padukuhan);
        $padukuhan->delete();
        return redirect()->back()->with('success', 'Padukuhan deleted successfully!');

    }

    /**
     * Store a newly created resource in storage.
     */

}
