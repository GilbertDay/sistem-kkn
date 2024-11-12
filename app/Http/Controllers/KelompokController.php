<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelompok;
use App\Models\User;
use App\Models\Padukuhan;


class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function tampil($padukuhan_id)
    {
        $kelompoks = Kelompok::with(['padukuhan.daftarKkn'])->where('padukuhan_id', $padukuhan_id)->first();

        // return response()->json($kelompoks);

        // dd($kelompoks);

       // Ambil ID siswa yang sudah ada di tabel kelompok
        // $padukuhanIdsInKelompok = Kelompok::pluck('padukuhan_id')->toArray();


        $siswa = User::where('type', 0)
            ->where('exist_group', 0)
            ->get();

        // $padukuhan = Padukuhan::
        //     whereNotIn('id', $padukuhanIdsInKelompok)
        //     ->get();


        $anggota = [];
        if ($kelompoks) {
            $id_anggota = explode(',', $kelompoks->anggota);

            foreach ($id_anggota as $id) {
                $anggota[] = User::find($id);
            }
        }

        $id_padukuhan = $padukuhan_id;

        return view('pages/admin/kelompok',compact('kelompoks','siswa','id_padukuhan','anggota'));
    }


    public function searchSiswa(Request $request)
    {
        $query = $request->get('query');
        $kelompokId = $request->get('kelompok_id');

        // Ambil anggota dari kelompok dengan `kelompok_id` yang diberikan
        $kelompok = Kelompok::where('id', $kelompokId)->first();

        // Jika kelompok ditemukan, ambil anggota-anggota tersebut
        if ($kelompok) {
            $siswaIdsInKelompok = explode(',', $kelompok->anggota); // Ambil anggota dari kolom `anggota` di tabel `kelompok`

            // Update exist_group menjadi 3 untuk anggota yang ada di kelompok tersebut
            User::whereIn('id', $siswaIdsInKelompok)->update(['exist_group' => 3]);

        }
        // Filter hasil pencarian
        $siswaQuery = User::where('type', 0)->where('exist_group', 0);

        if ($query) {
            $siswaQuery->where('name', 'LIKE', "%{$query}%");
        }

        $siswa = $siswaQuery->get();

        return response()->json($siswa);

        // Jika kelompok tidak ditemukan, kembalikan hasil kosong
        // return response()->json([]);
    }

    public function getKelompokMembers(Request $request)
    {
        $kelompokId = $request->get('kelompok_id');

        // Ambil data kelompok berdasarkan ID
        $kelompok = Kelompok::find($kelompokId);


        if ($kelompok) {
            // Periksa apakah anggota_id berisi lebih dari satu ID
            if (strpos($kelompok->anggota, ',') !== false) {
                // Jika ada koma, pisahkan menjadi array
                $siswaIdsInKelompok = explode(',', $kelompok->anggota);
            } else {
                // Jika tidak ada koma, masukkan ID tunggal ke dalam array
                $siswaIdsInKelompok = [$kelompok->anggota];
            }

            // Cari anggota di tabel User yang sesuai dengan ID dalam array dan exist_group = 3
            $members = User::whereIn('id', $siswaIdsInKelompok)
                            ->where('exist_group', 3)
                            ->get(['id', 'name']);

            return response()->json($members);
        }

        // Jika kelompok tidak ditemukan, kembalikan hasil kosong
        return response()->json([]);
    }

    public function searchSiswaEdit(Request $request)
    {
        $query = $request->get('query');
        $kelompokId = $request->get('kelompok_id');
        $selectedIds = $request->get('selected_ids', []); // Ambil selectedIds dari request (berupa array ID yang sudah ditambahkan dalam tag)

        // Ambil anggota dari kelompok dengan `kelompok_id` yang diberikan
        $kelompok = Kelompok::where('id', $kelompokId)->first();

        // Jika kelompok ditemukan, ambil anggota-anggota tersebut
        if ($kelompok) {
            $siswaIdsInKelompok = explode(',', $kelompok->anggota); // Ambil anggota dari kolom `anggota` di tabel `kelompok`

            // Update exist_group menjadi 3 untuk anggota yang ada di kelompok tersebut
            User::whereIn('id', $siswaIdsInKelompok)->update(['exist_group' => 3]);
        }

        // Filter hasil pencarian, tampilkan pengguna dengan exist_group = 0 atau 3, dan tidak termasuk dalam selectedIds
        $siswaQuery = User::where('type', 0)
                        ->whereIn('exist_group', [0, 3])
                        ->whereNotIn('id', $selectedIds); // Filter pengguna yang tidak berada dalam selectedIds

        if ($query) {
            $siswaQuery->where('name', 'LIKE', "%{$query}%");
        }

        $siswa = $siswaQuery->get();

        return response()->json($siswa);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function editKelompok(Request $request)
    {

        $anggota = explode(',', $request->selected_ids);
        $anggota = array_filter($anggota);
        foreach ($anggota as $anggota_id) {
            $user = User::find($anggota_id);
            $user->exist_group = 1;
            $user->save();
        }

        $kelompok = Kelompok::find($request->kelompok_id);
        $kelompok->nama_kelompok = $request->nama_kelompok;
        $kelompok->anggota = $request->selected_ids;
        $kelompok->save();

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function tambahKelompok(Request $request)
    {

        // dd($request->all());
         // Validate the incoming request data
        //  $request->validate([
        //     'nama_kelompok' => 'nullable|string|max:255',
        //     'padukuhan_id' => 'required|exists:padukuhans,id',
        //     'tema' => 'nullable|string|max:255',
        //     'ketua_id' => 'required|exists:users,id|unique:kelompoks,ketua_id',
        //     'anggota' => 'nullable|json',
        //     'tanggal_mulai' => 'required|date',
        //     'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        //     'status' => 'nullable|string|max:255',
        // ]);

        // $user = User::find($request->ketua_id);
        // $user->exist_group = 1;
        // $user->save();

        $anggota = explode(',', $request->selected_ids);
        $anggota = array_filter($anggota);
        foreach ($anggota as $anggota_id) {
            $user = User::find($anggota_id);
            $user->exist_group = 1;
            $user->save();
        }

        // Create the kelompok
        Kelompok::create([
            'nama_kelompok' => $request->nama_kelompok,
            'padukuhan_id' => $request->padukuhan_id,
            'ketua_id' => $request->ketua_id,
            // 'anggota' => json_encode($request->selected_ids),
            'anggota' => $request->selected_ids,
            'tanggal_mulai' => $request->start_date,
            'tanggal_selesai' => $request->end_date,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Kelompok created successfully.');
    }

    public function hapusKelompok(Request $request) {
        $kelompok = Kelompok::find($request->kelompok_id);
        $anggota = explode(',', $kelompok->anggota);

        foreach ($anggota as $anggota_id) {
            $user = User::find($anggota_id);
            $user->exist_group = 0;
            $user->save();
        }

        $kelompok->delete();
        return redirect()->back();
    }

    // public function searchSiswaEdit(Request $request){
    //     $query = $request->get('query'); // Mengambil kata kunci pencarian dari request

    //     // Jika ada kata kunci, cari siswa berdasarkan kata kunci
    //      // Ambil ID anggota yang sudah ada di kelompok dari database
    //      $siswaIdsInKelompok = Kelompok::pluck('anggota')->toArray();


    //      // Pisahkan ID anggota menjadi array
    //      $siswaIdsInKelompok = explode(',', implode(',', $siswaIdsInKelompok));


    //     if ($query) {
    //         $siswa = User::where('type', 0)
    //         ->where('name', 'LIKE', "%{$query}%")
    //         ->where('exist_group', 0)
    //         ->get();
    //     }
    //     // Jika tidak ada kata kunci, ambil semua data siswa
    //     else {
    //         $siswa = User::where('type', 0)->where('exist_group', 0)->get();
    //     }

    //     return response()->json($siswa);
    // }


    public function update(Request $request, string $id)
    {
        // Validate the request data
        $request->validate([
            'nama_kelompok' => 'nullable|string|max:255',
            'padukuhan_id' => 'required|exists:padukuhans,id',
            'tema' => 'nullable|string|max:255',
            // 'ketua_id' => 'required|exists:users,id|unique:kelompoks,ketua_id,' . $kelompok->id,
            'anggota' => 'nullable|json',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'nullable|string',
        ]);

        // Update the kelompok
        $kelompok->update($request->all());

        return redirect()->route('kelompoks.index')->with('success', 'Kelompok updated successfully.');
    }



    public function destroy(string $id)
    {
        $kelompok->delete();

        return redirect()->route('kelompoks.index')->with('success', 'Kelompok deleted successfully.');
    }
}
