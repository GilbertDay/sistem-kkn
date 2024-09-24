<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Kelompok;
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

    }
    /**
     * Display a listing of the resource.
     */
    public function laporan()
    {
        $idKetua = Auth::id();

        $laporans = Laporan::whereHas('kelompok.users', function ($query) use ($idKetua) {
            $query->where('ketua_id', $idKetua);
        })->get();

        $idKelompok = Kelompok::where('ketua_id', $idKetua)->pluck('id')->first();

        return view('pages/users/laporan', compact('laporans','idKelompok'));
    }

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
    public function viewLaporan(Request $req)
    {
        return response()->file(public_path($req->file),['Content-Type' => 'application/pdf']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporan $laporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanRequest $request, Laporan $laporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        //
    }
}
