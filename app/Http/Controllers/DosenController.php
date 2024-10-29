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
        $padukuhans = Padukuhan::with('daftarKkn')->where('dosen_id', Auth::id())->get();
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
}
