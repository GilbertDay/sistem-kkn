<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="flex flex-col gap-4">
            <button type="button" data-bs-toggle="modal" data-bs-target="#uploadLaporan"
                class="p-2 font-semibold text-center bg-green-400 rounded-lg cursor-pointer hover:bg-slate-300">
                Upload Laporan
            </button>
            <div class="card laporan-tabel" id="laporan-masuk">
                <div class="text-xl text-white bg-gray-400 card-header">Riwayat Upload Laporan</div>
                <div class="card-body">
                    @if($laporans->isEmpty())
                        <p>Belum Pernah Upload Laporan</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Tanggal Upload</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporans as $laporan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $laporan->judul }}</td>
                                        <td>{{ $laporan->created_at }}</td>
                                        <td>
                                            <form action="{{ route('viewLaporan') }}" target="_blank" method="POST">
                                                @csrf
                                                <input type="hidden" value="{{ $laporan->file }}" name="file">
                                                <button type="submit" class="p-2 text-black bg-yellow-400 rounded-lg">
                                                    <i class="mr-1 fa-solid fa-eye"></i>LAPORAN
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            @if($laporan->status == 'proses') Proses
                                            @elseif($laporan->status == 'diterima') Diterima
                                            @elseif($laporan->status == 'ditolak') Ditolak
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Edit Button Trigger Modal -->
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" 
                                                data-bs-target="#editLaporan{{ $laporan->id }}">
                                                Edit
                                            </button>
                                            
                                            <!-- Delete Button Trigger Modal -->
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" 
                                                data-bs-target="#deleteLaporan{{ $laporan->id }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit Laporan -->
                                    <div class="modal fade" id="editLaporan{{ $laporan->id }}" tabindex="-1" aria-labelledby="editLaporanLabel{{ $laporan->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editLaporanLabel{{ $laporan->id }}">Edit Laporan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('updateLaporan', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="judul" class="form-label">Judul Laporan</label>
                                                            <input type="text" class="form-control" name="judul" id="judul" value="{{ $laporan->judul }}" required />
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="laporan_akhir" class="form-label">File</label>
                                                            <input type="file" class="form-control" name="laporan_akhir" id="laporan_akhir" />
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteLaporan{{ $laporan->id }}" tabindex="-1" aria-labelledby="deleteLaporanLabel{{ $laporan->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteLaporanLabel{{ $laporan->id }}">Hapus Laporan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('deleteLaporan', $laporan->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus laporan ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal Upload Laporan -->
        <div class="modal fade" id="uploadLaporan" tabindex="-1" aria-labelledby="uploadLaporanLabel" aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadLaporanLabel">Upload Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('uploadLaporan') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" value="{{ $idKelompok }}" name="kelompok_id">
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul Laporan</label>
                                <input type="text" class="form-control" name="judul" id="judul" required />
                            </div>
                            <div class="mb-3">
                                <label for="laporan_akhir" class="form-label">File</label>
                                <input type="file" class="form-control" name="laporan_akhir" id="laporan_akhir" required />
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
    </div>
</x-app-layout>
