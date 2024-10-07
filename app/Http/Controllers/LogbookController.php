<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLogbookRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateLogbookRequest;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logbooks = Logbook::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);

        return view('pages/users/logbook', compact('logbooks'));
    }

    public function adddLogbook(Request $request){
        // dd($request->all());
        $logbook = new Logbook();
        $logbook->user_id = Auth::id();
        $logbook->isi = $request->isi;
        $logbook->tanggal = $request->tanggal;
        $logbook->save();

        return redirect()->back();
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
    public function store(StoreLogbookRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Logbook $logbook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logbook $logbook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function editLogbook(Request $req)
    {
        $logbook = Logbook::find($req->id);

        $logbook->isi = $req->isi;
        $logbook->tanggal = $req->tanggal;
        $logbook->save();

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function hapusLogbook(Request $req)
    {
        $logbook = Logbook::find($req->id);
        $logbook->delete();
        return redirect()->back();

    }
}
