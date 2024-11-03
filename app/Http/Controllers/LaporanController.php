<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Kelompok;
use App\Models\Logbook;
use App\Models\Padukuhan;
use App\Http\Requests\StoreLaporanRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateLaporanRequest;
use Illuminate\Http\Request;


class LaporanController extends Controller
{

    public function cekLaporan(){
        $idDosen = Auth::id();
        // dd($idDosen);
        // $laporanProses = Laporan::where('status', 'proses')->get();
        // $laporanTerima = Laporan::where('status', 'diterima')->get();
        // $laporanTolak = Laporan::where('status', 'ditolak')->get();

    $laporanProses = Laporan::where('status', 'proses')
    ->whereHas('kelompok.padukuhan', function ($query) use ($idDosen) {
        $query->where('dosen_id', $idDosen);
    })->get();

    $laporanTerima = Laporan::where('status', 'diterima')
        ->whereHas('kelompok.padukuhan', function ($query) use ($idDosen) {
            $query->where('dosen_id', $idDosen);
        })->get();

    $laporanTolak = Laporan::where('status', 'ditolak')
        ->whereHas('kelompok.padukuhan', function ($query) use ($idDosen) {
            $query->where('dosen_id', $idDosen);
        })->get();

        return view('pages/dosen/StatusLaporan', compact('laporanTerima', 'laporanTolak','laporanProses'));
    }

    public function cekLogbook(){
        $padukuhan = Padukuhan::where('dosen_id', Auth::id())->get();
        dd($padukuhan);
        $logbooks = Logbook::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('pages/dosen/statusLogbook', compact('logbooks'));
    }

    public function laporan()
    {
        $idKetua = Auth::id();

        $laporans = Laporan::whereHas('kelompok.users', function ($query) use ($idKetua) {
            $query->where('ketua_id', $idKetua);
        })->get();

        $idKelompok = Kelompok::where('ketua_id', $idKetua)->pluck('id')->first();

        return view('pages/users/laporan', compact('laporans','idKelompok'));
    }

    public function uploadLaporan(Request $req)
    {
        $idUser = Auth::id();
        $fileName = $idUser.'-'.time().'-'.$req->file('laporan_akhir')->getClientOriginalName();
        $path = $req->file('laporan_akhir')->storeAs('laporan_akhir', $fileName, 'public');

        $laporan = Laporan::create([
            'kelompok_id' => $req->kelompok_id,
            'judul' => $req->judul,
            'status' => 'proses',
            'file' => '/storage/'.$path,
        ]);
        // Laporan::find($req->transaksi_id)->update(['laporan_akhir' => '/storage/'.$path]);

        return redirect('/');

    }

    public function viewLaporan(Request $req)
{
    // Ensure the 'file' parameter is present in the request
    if (!$req->has('file')) {
        return redirect()->back()->withErrors('File parameter is missing.');
    }

    //  the file path
    $filePath = public_path('storage/laporan_akhir/' . basename($req->file));

    // Check if the file exists and output a detailed error if not
    if (!file_exists($filePath)) {
        return redirect()->back()->withErrors("File not found at path: $filePath");
    }

    // Serve the file as a response
    return response()->file($filePath, [
        'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
    ]);


}
public function edit($id)
{
    $laporan = Laporan::findOrFail($id);
    return view('laporan.edit', compact('laporan'));
}

// Update the specified resource in storage
public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'laporan_akhir' => 'file|mimes:pdf,doc,docx|max:2048',
    ]);

    $laporan = Laporan::findOrFail($id);
    $laporan->judul = $request->judul;
    
    if ($request->hasFile('laporan_akhir')) {
        $laporan->file = $request->file('laporan_akhir')->store('laporan');
    }

    $laporan->save();

    return redirect()->route('laporan.index')->with('success', 'Laporan updated successfully.');
}

// Remove the specified resource from storage
public function destroy($id)
{
    \Log::info('Delete attempt by User ID: ' . auth()->id() . ' for Laporan ID: ' . $id);

    $laporan = Laporan::find($id);

    if (!$laporan) {
        \Log::error('Laporan not found: ' . $id);
        return redirect()->back()->with('error', 'Laporan not found.');
    }

    // Check permissions
    if (!auth()->user()->canDeleteLaporan()) {
        \Log::error('Unauthorized delete attempt by User ID: ' . auth()->id());
        return redirect()->back()->with('error', 'You do not have permission to delete this laporan.');
    }

    $laporan->delete();

    \Log::info('Deleted Laporan ID: ' . $id);
    return redirect()->back()->with('success', 'Laporan deleted successfully.');
}

public function canDeleteLaporan()
{
    // Logika untuk menentukan apakah pengguna dapat menghapus laporan
    return $this->role === 'admin'; // Contoh logika
}



}



    


    
    


