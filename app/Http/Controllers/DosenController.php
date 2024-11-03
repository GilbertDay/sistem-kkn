<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Padukuhan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DosenController extends Controller
{
    public function logbookIndex(){
        $padukuhans = Padukuhan::where('dosen_id', Auth::id())->get();
        return view('pages/dosen/statusLogbook', compact('padukuhans'));
    }

    public function viewLogbook($id){
        // $uniqueUserCount = Logbook::where('padukuhan_id', $id)
        // ->distinct('user_id')
        // ->count('user_id');

        $logbooks = Logbook::with('user')
        ->where('padukuhan_id', $id) // Sesuaikan padukuhan_id jika diperlukan
        ->orderBy('user_id')
        ->orderBy('tanggal')
        ->get()
        ->groupBy('user_id');

        return view('pages/dosen/viewLogbook', compact('logbooks'));
    }
    public function acceptLogbook($id)
{
    $logbook = Logbook::find($id);

    if ($logbook) {
        $logbook->status = 'diterima'; // Change the status to 'diterima'
        $logbook->save(); // Save the changes

        return redirect()->back()->with('success', 'Logbook has been accepted.');
    }

    return redirect()->back()->with('error', 'Logbook not found.');
}

public function rejectLogbook(Request $request, $id)
{
    $logbook = Logbook::find($id);

    if ($logbook) {
        $logbook->status = 'ditolak'; // Change the status to 'ditolak'
        $logbook->save(); // Save the changes

        return redirect()->back()->with('success', 'Logbook has been rejected.');
    }

    return redirect()->back()->with('error', 'Logbook not found.');
}
public function acceptLaporan($id)
    {
        $laporan = Laporan::find($id);

        if ($laporan) {
            $laporan->status = 'accepted';
            $laporan->save();

            return redirect()->back()->with('success', 'Laporan accepted successfully.');
        }

        return redirect()->back()->with('error', 'Laporan not found.');
    }

    // Method to reject the laporan with a reason
    public function rejectLaporan(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string',
        ]);

        $laporan = Laporan::find($id);

        if ($laporan) {
            $laporan->status = 'rejected';
            $laporan->catatan = $request->input('catatan');
            $laporan->save();

            return redirect()->back()->with('success', 'Laporan rejected successfully.');
        }

        return redirect()->back()->with('error', 'Laporan not found.');
    }


public function cekLaporan(Request $request, $id)
{
    $laporan = Laporan::find($id);

    if (!$laporan) {
        return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
    }

    // Log the current status
    \Log::info('Current Status: ' . $laporan->status);

    $laporan->status = 'accepted';
    $laporan->save();

    // Log the new status
    \Log::info('New Status: ' . $laporan->status);

    return redirect()->back()->with('success', 'Laporan berhasil diterima.');
}




    
}
