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
        $regulers = DaftarKkn::where('tipe', 'reguler')->withCount('padukuhans')->paginate(10);
        return view('pages/admin/kkn-reguler', compact('regulers'));
    }
    public function indexKknTematik()
    {
        $tematiks = DaftarKkn::where('tipe', 'tematik')->withCount('padukuhans')->paginate(10);

        return view('pages/admin/kkn-tematik', compact('tematiks'));
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
   
    public function edit($id)
{
    $daftarKkn = DaftarKkn::find($id);

    if ($daftarKkn) {
        return view('pages/admin/edit-kkn', compact('daftarKkn'));
    } else {
        return redirect()->back()->with('error', 'Data KKN tidak ditemukan');
    }
}

public function update(Request $request, $id)
{
    $daftarKkn = DaftarKkn::find($id);

    if ($daftarKkn) {
        $daftarKkn->update([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'lokasi' => $request->lokasi,
            'kecamatan' => $request->kecamatan,
            'tema' => $request->tema,
            'tipe' => $request->tipe,
        ]);
        $tematik = daftarKkn::findOrFail($id);
    $tematik->update($request->all());
    return redirect()->route('tematik.index')->with('success', 'KKN Tematik berhasil diperbarui!');


        return redirect()->route('kkn.index')->with('success', 'Data KKN berhasil diperbarui');
    } else {
        return redirect()->back()->with('error', 'Data KKN tidak ditemukan');
    }
}
public function destroy($id)
{
    // Find the record by ID
    $tematik = daftarKkn::find($id);

    // Check if the record exists
    if ($tematik) {
        // Delete the record
        $tematik->delete();

        // Redirect back with a success message
        return redirect()->route('kkn.index')->with('success', 'KKN Tematik deleted successfully!');
    }

    // If the record doesn't exist, return with an error message
    return redirect()->route('kkn.index')->with('error', 'KKN Tematik not found!');
}

public function delete($id)
{
    // Temukan data KKN berdasarkan ID
    $kkn = daftarKkn::findOrFail($id);

    // Hapus data KKN
    $kkn->delete();

    // Redirect kembali dengan pesan sukses
    return redirect()->route('kkn.index')->with('success', 'KKN berhasil dihapus');
}
}




