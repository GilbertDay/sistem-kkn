<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <div class="flex justify-end gap-6 p-3 ">
            <button class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300"
                onclick="toggleTable('laporan-masuk')">Laporan Masuk</button>
            <button class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300"
                onclick="toggleTable('laporan-diterima')">Laporan Diterima</button>
            <button class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300"
                onclick="toggleTable('laporan-ditolak')">Laporan Ditolak</button>
        </div>

        <!-- Display success message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col gap-4">
            <!-- Laporan Masuk -->
            <div class="card laporan-tabel" id="laporan-masuk">
                <div class="text-xl text-white bg-gray-400 card-header">Laporan Masuk</div>
                <div class="card-body">
                    @if($laporanProses->isEmpty())
                        <p>Belum Ada Laporan Masuk</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Nama Kelompok</th>
                                    <th scope="col">Nama Padukuhan</th>
                                    <th scope="col">Ketua Kelompok</th>
                                    <th scope="col">Laporan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporanProses as $lp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $lp->judul }}</td>
                                        <td>{{ $lp->kelompok->nama_kelompok }}</td>
                                        <td>{{ $lp->kelompok->padukuhan->desa }}</td>
                                        <td>{{ $lp->kelompok->users->name }}</td>
                                        <td>
                                            <form action="{{route('viewLaporan')}}" target="_blank" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{$lp->file}}" name="file">
                                                <button type="submit" class="p-2 text-white bg-gradient-to-r from-teal-400 to-blue-500 hover:from-blue-500 hover:to-teal-400 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-200">
                                                    <i class="mr-1 fa-solid fa-eye"></i>Lihat laporan
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <!-- Terima Button -->
                                            <form action="{{ route('acceptLaporan', $lp->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="p-2 text-black bg-green-400 rounded-lg">Terima</button>
                                            </form>
                                            <!-- Tolak Button (Modal Trigger) -->
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#modalTolak{{ $lp->id }}"
                                                class="p-2 text-black bg-red-500 rounded-lg">Tolak</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

            <!-- Modal for Tolak with Reason -->
            @foreach($laporanProses as $lp)
                <div class="modal fade" id="modalTolak{{ $lp->id }}" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTolakLabel">Alasan Penolakan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('rejectLaporan', $lp->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <textarea class="form-control" name="catatan" rows="3"></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- JavaScript to toggle table views -->
            <script>
                function toggleTable(tableId) {
                    var tables = document.getElementsByClassName('laporan-tabel');
                    for (var i = 0; i < tables.length; i++) {
                        tables[i].style.display = 'none';
                    }
                    document.getElementById(tableId).style.display = 'block';
                }
            </script>
        </div>
    </div>
</x-app-layout>
