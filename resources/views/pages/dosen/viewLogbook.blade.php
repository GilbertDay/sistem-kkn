<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
            <div class="flex flex-col gap-4">

                @foreach($logbooks as $userId => $logbook)
                <div class="card laporan-tabel" id="laporan-masuk">
                    <div class="text-xl text-white bg-gray-400 card-header">Logbook {{$logbook->first()->user->name .' '. '(' . ' '. $logbook->first()->user->nim. ' ' . ')'}}</div>
                    <div class="card-body">
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
                                @foreach($logbook as $l)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $l->isi }}</td>
                                    <td>{{ $l->tanggal }}</td>
                                    <td>
                                        @if($l->status == 'proses')
                                        Proses
                                        @elseif($l->status == 'diterima')
                                        Diterima
                                        @elseif($l->status == 'ditolak')
                                        Ditolak
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="p-2 text-black bg-green-400 rounded-lg">Terima</button>
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#modalTolak{{ $l->id }}"
                                            class="p-2 text-black bg-red-500 rounded-lg">Tolak</button>
                                    </td>
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
