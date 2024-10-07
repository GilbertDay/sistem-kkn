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

        <div class="flex flex-col gap-4">
            <!-- Laporan Proses -->
            <div class="card laporan-tabel" id="laporan-masuk">
                <div class="text-xl text-white bg-gray-400 card-header">Laporan Masuk</div>
                <div class="card-body">
                    @if($laporanProses->isEmpty())
                    <tr>Belum Ada Laporan Masuk </tr>
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
                                <td>{{ $lp->kelompok->padukuhan->lokasi }}</td>
                                <td>{{ $lp->kelompok->users->name }}</td>
                                <td>
                                    <form action="{{route('viewLaporan')}}" target="_blank" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$lp->file}}" name="file">
                                        <button type="submit" class="p-2 text-black bg-yellow-400 rounded-lg"><i
                                                class="mr-1 fa-solid fa-eye"></i>View</button>
                                    </form>
                                </td>
                                <td>
                                    <button type="button" class="p-2 text-black bg-green-400 rounded-lg">Terima</button>
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

            <!-- Laporan Terima -->
            <div class="card laporan-tabel" id="laporan-diterima" style="display:none;">
                <div class="text-xl text-white bg-green-400 card-header">Laporan Diterima</div>
                <div class="card-body">
                    @if($laporanTerima->isEmpty())
                    <tr>Belum Ada Laporan Diterima </tr>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporanTerima as $lt)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lt->judul }}</td>

                                <td>{{ $lt->kelompok->nama_kelompok }}</td>
                                <td>{{ $lt->kelompok->padukuhan->lokasi }}</td>
                                <td>{{ $lt->kelompok->users->name }}</td>
                                <td>
                                    <form action="{{route('viewLaporan')}}" target="_blank" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$lp->file}}" name="file">
                                        <button type="submit" class="p-2 text-black bg-yellow-400 rounded-lg"><i
                                                class="mr-1 fa-solid fa-eye"></i>View</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>

            <!-- Laporan Tolak -->
            <div class="card laporan-tabel" id="laporan-ditolak" style="display:none;">
                <div class="text-xl text-white bg-red-400 card-header">Laporan Ditolak</div>
                <div class="card-body">
                    @if($laporanTolak->isEmpty())
                    <tr>Belum Ada Laporan Ditolak </tr>
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
                                <th scope="col">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporanTolak as $lt)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lt->judul }}</td>
                                <td>{{ $lt->kelompok->nama_kelompok }}</td>
                                <td>{{ $lt->kelompok->padukuhan->lokasi }}</td>
                                <td>{{ $lt->kelompok->users->name }}</td>
                                <td>
                                    <form action="{{route('viewLaporan')}}" target="_blank" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$lp->file}}" name="file">
                                        <button type="submit" class="p-2 text-black bg-yellow-400 rounded-lg"><i
                                                class="mr-1 fa-solid fa-eye"></i>View</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>

    </div>

    @foreach($laporanProses as $lp)
    <div class="modal fade" id="modalTolak{{ $lp->id }}" tabindex="-1" aria-labelledby="modalTolakLabel"
        aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTolakLabel">Alasan Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tolakLaporan') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>

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

    <script>
        function toggleTable(tableId) {
            // Tutup semua tabel
            var tables = document.getElementsByClassName('laporan-tabel');
            for (var i = 0; i < tables.length; i++) {
                tables[i].style.display = 'none';
            }

            // Tampilkan tabel yang dipilih
            document.getElementById(tableId).style.display = 'block';
        }

    </script>


</x-app-layout>
