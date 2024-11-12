<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLogbookRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Requests\UpdateLogbookRequest;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logbooks = Logbook::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        $id = Auth::id();
        $kelompok = DB::table('kelompoks')
        ->where('ketua_id', $id)
        ->orWhere('anggota', 'REGEXP', '(^|,)' . $id . '(,|$)')
        ->first();

        return view('pages/users/logbook', compact('logbooks','kelompok'));
    }

    public function addLogbook(Request $request)
    {
        // Validate the incoming request to ensure required fields are filled
        $request->validate([
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string', // Allows 'catatan' to be empty
            'padukuhan_id' => 'required|integer'
        ]);
    
        // Create and save the logbook entry
        $logbook = new Logbook();
        $logbook->user_id = Auth::id();
        $logbook->isi = $request->isi;
        $logbook->tanggal = $request->tanggal;
        $logbook->catatan = $request->catatan ?? ''; // Default to empty string if 'catatan' is NULL
        $logbook->padukuhan_id = $request->padukuhan_id;
        $logbook->save();
    
        return redirect()->back();
    }
    

    public function editLogbook(Request $req)
    {
        $logbook = Logbook::find($req->id);

        $logbook->isi = $req->isi;
        $logbook->tanggal = $req->tanggal;
        $logbook->catatan = $req->catatan;
        $logbook->save();

        return redirect()->back();

    }

    public function hapusLogbook(Request $req)
    {
        $logbook = Logbook::find($req->id);
        $logbook->delete();
        return redirect()->back();
    }

    public function accept($id){
        $logbook = Logbook::find($id);
        $logbook->status = 'diterima';
        $logbook->save();
        return redirect()->back();
    }

    public function reject($id){
        $logbook = Logbook::find($id);
        $logbook->status = 'ditolak';
        $logbook->save();
        return redirect()->back();
    }
}
