<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">


        <div class="flex flex-col gap-4">
            <button type="button" data-bs-toggle="modal" data-bs-target="#addLogbook"
                class="p-2 font-semibold text-center text-black bg-green-400 rounded-lg cursor-pointer hover:bg-slate-300">
                Tambah Logbook</button>
            <div class="card laporan-tabel" id="laporan-masuk">
                <div class="text-xl text-white bg-gray-400 card-header">Logbook Saya</div>
                <div class="card-body">

                    @if($logbooks->isEmpty())
                    <tr>Belum Ada Data </tr>
                    @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kegiatan</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logbooks as $logbook)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $logbook->isi }}</td>
                                <td>{{ $logbook->tanggal }}</td>
                                <td>
                                    @if($logbook->status == 'proses')
                                    Proses
                                    @elseif($logbook->status == 'diterima')
                                    Diterima
                                    @elseif($logbook->status == 'ditolak')
                                    Ditolak
                                    @endif
                                </td>
                                <td>
                                    <a type="button" class="p-2 text-black bg-yellow-400 rounded-lg"><i
                                            class="mr-1 fa-solid fa-eye"></i>View</a>
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#editLogbook-{{ $logbook->id }}"
                                        class="p-2 text-black bg-blue-400 rounded-lg">Edit</button>
                                    <button type="button" data-bs-toggle="modal"
                                        data-bs-target="#hapusLogbook-{{ $logbook->id }}"
                                        class="p-2 text-black bg-red-500 rounded-lg">Hapus</button>
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
        <div class="modal fade" id="addLogbook" tabindex="-1" aria-labelledby="addLogbookLabel" aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLogbookLabel">Add Logbook</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('addLogbook') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                            <div class="mb-3">
                                <label for="isi" class="form-label">Kegiatan</label>
                                <input type="text" class="form-control" name="isi" id="isi" rows="3" />
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Kegiatan</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" rows="3" />
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

        @foreach($logbooks as $logbook)
        <div class="modal fade" id="editLogbook-{{ $logbook->id }}" tabindex="-1" aria-labelledby="editLogbookLabel"
            aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLogbookLabel">Edit Logbook</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('editLogbook') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" value="{{$logbook->id}}" name="id">
                            <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
                            <div class="mb-3">
                                <label for="isi" class="form-label">Kegiatan</label>
                                <input type="text" class="form-control" value="{{ $logbook->isi }}" name="isi" id="isi"
                                    rows="3" />
                            </div>
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Kegiatan</label>
                                <input type="date" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($logbook->tanggal)->format('Y-m-d') }}"
                                    name="tanggal" id="tanggal" rows="3" />
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

        <div class="modal fade" id="hapusLogbook-{{ $logbook->id }}" tabindex="-1" aria-labelledby="hapusLogbookLabel"
            aria-hidden="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapusLogbookLabel">hapus Logbook</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('hapusLogbook') }}" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" value="{{$logbook->id}}" name="id">
                            <div>Apakah yakin ingin menghapus logbook ini ?</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
</x-app-layout>
