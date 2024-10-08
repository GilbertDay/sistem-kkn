<?php

namespace App\Http\Controllers;

use App\Models\DaftarKkn;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDaftarKknRequest;
use App\Http\Requests\UpdateDaftarKknRequest;

class DaftarKknController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexKknReguler()
    {
        $regulers = DaftarKkn::where('tipe', 'reguler')->paginate(10);
        return view('pages/admin/kkn-reguler', compact('regulers'));
    }
    public function indexKknTematik()
    {
        $tematiks = DaftarKkn::where('tipe', 'tematik')->paginate(10);

        return view('pages/admin/kkn-reguler', compact('tematiks'));
    }

    public function tambahKKN(Request $req){

        DaftarKkn::create([
            'tahun' => $req->tahun,
            'semester' => $req->semester,
            'lokasi' => $req->lokasi,
            'kecamatan' => $req->kecamatan,
            'tema' => $req->tema,
            'tipe' => $req->tipe,
        ]);

        return redirect()->back();
    }
    public function destroy(DaftarKkn $daftarKkn)
    {
        //
    }
}
