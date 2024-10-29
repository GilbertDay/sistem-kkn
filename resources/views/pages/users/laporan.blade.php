<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">


        <div class="flex flex-col gap-4">
            <button type="button" data-bs-toggle="modal" data-bs-target="#uploadLaporan"
                class="p-2 font-semibold text-center bg-green-400 rounded-lg cursor-pointer hover:bg-slate-300">
                Upload
                Laporan</button>
            <div class="card laporan-tabel" id="laporan-masuk">
                <div class="text-xl text-white bg-gray-400 card-header">Riwayat Upload Laporan </div>
                <div class="card-body">

                    @if($laporans->isEmpty())
                    <tr>Belum Pernah Upload Laporan </tr>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Tanggal Upload</th>
                                <th scope="col">File</th>
                                <th scope="col">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporans as $laporan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $laporan->judul }}</td>
                                <td>{{ $laporan->created_at }}</td>
                                <td>
                                    <form action="{{route('viewLaporan')}}" target="_blank" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{$laporan->file}}" name="file">
                                        <button type="submit" class="p-2 text-black bg-yellow-400 rounded-lg"><i
                                                class="mr-1 fa-solid fa-eye"></i>View</button>
                                    </form>
                                </td>
                                <td>
                                    @if($laporan->status == 'proses')
                                    Proses
                                    @elseif($laporan->status == 'diterima')
                                    Diterima
                                    @elseif($laporan->status == 'ditolak')
                                    Ditolak
                                    @endif

                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal Upload Laporan -->
        <div class="modal fade" id="uploadLaporan" tabindex="-1" aria-labelledby="uploadLaporanLabel"
            aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadLaporanLabel">Upload Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('uploadLaporan') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" value="{{$idKelompok}}" name="kelompok_id">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Laporan</label>
                                <input type="text" class="form-control" name="judul" id="judul" rows="3" />
                            </div>
                            <div class="mb-3">
                                <label for="File" class="form-label">File</label>
                                <input type="file" class="form-control" name="laporan_akhir" id="laporan_akhir"
                                    rows="3" />
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>
