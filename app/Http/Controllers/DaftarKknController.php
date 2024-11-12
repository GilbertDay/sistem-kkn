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
       
    }

    // Method to update the KKN record
    public function update(Request $request, $id)
    {
        // Validate input
        $validated = $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'lokasi' => 'required',
            'kecamatan' => 'required',
            'tema' => 'required',
        ]);

       $tematik = DaftarKkn::find($id);
       $tematik->update($validated);


        return redirect()->back()->with('success', 'Data KKN berhasil diperbarui');
    }

    // Method to delete the KKN record
    public function destroy($id)
    {
        $tematik = DaftarKkn::findOrFail($id);
        $tematik->delete();

        return redirect()->back()->with('success', 'Data KKN berhasil dihapus');
    }
    public function delete($id)
    {
        // Find the KKN Tematik by ID and delete it
        $tematik = DaftarKkn::findOrFail($id);
        $tematik->delete();

        // Redirect back with a success message
        return redirect()->route('tematik.index')->with('success', 'KKN Tematik deleted successfully');
    }

    public function editTematik(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validated = $request->validate([
            'tahun' => 'required|string|max:255',
            'semester' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'tema' => 'required|string|max:255',
        ]);
    
        // Cari data KKN berdasarkan ID
        $tematik = DaftarKkn::findOrFail($id);
    
        // Update data KKN berdasarkan input form
        $tematik->update([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'lokasi' => $request->lokasi,
            'kecamatan' => $request->kecamatan,
            'tema' => $request->tema,
        ]);
    
        // Redirect setelah update berhasil ke halaman edit dengan pesan sukses
        return redirect()->route('editKkn', $tematik->id)->with('success', 'Data KKN Tematik berhasil diperbarui');
    }
    
    
}



