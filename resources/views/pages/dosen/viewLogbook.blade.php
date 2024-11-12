<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <div class="flex flex-col gap-4">

            @foreach($logbooks as $userId => $logbook)
            <div class="card laporan-tabel" id="laporan-masuk">
                <div class="text-xl text-white bg-gray-400 card-header">
                    Logbook {{$logbook->first()->user->name .' '. '(' . ' '. $logbook->first()->user->nim. ' ' . ')'}}
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kegiatan</th>
                                <th scope="col">Catatan</th> <!-- Added Catatan header -->
                                <th scope="col">Tanggal</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logbook as $l)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $l->isi }}</td>
                                <td>{{ $l->catatan }}</td> <!-- Displaying Catatan data -->
                                <td>{{ $l->tanggal }}</td>

                                @if($l->status != 'proses')
                                    <td class="">
                                        @if($l->status == 'diterima')
                                            <div class="px-2 py-1 text-white bg-green-600 rounded-lg w-fit">Diterima</div>
                                        @elseif($l->status == 'ditolak')
                                            <div class="px-2 py-1 text-white bg-red-600 rounded-lg w-fit">Ditolak</div>
                                        @endif
                                    </td>
                                @else
                                    <td class="flex gap-6">
                                        <form action="{{ route('logbookAccept', $l->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="flex items-center w-4 gap-1 text-3xl text-green-600 rounded-lg">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </button>
                                        </form>

                                        <!-- Tombol untuk menolak dengan konfirmasi -->
                                        <button type="button" class="flex items-center w-4 gap-1 text-3xl text-red-600 rounded-lg" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $l->id }}">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </button>

                                        <!-- Modal Konfirmasi Reject -->
                                        <div class="modal fade" id="rejectModal{{ $l->id }}" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectModalLabel">Konfirmasi Tolak</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menolak logbook ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('logbookReject', $l->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-danger">Tolak</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
