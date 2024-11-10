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
                                    <!-- <th scope="col">Status</th> -->
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($logbook as $l)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $l->isi }}</td>
                                    <td>{{ $l->tanggal }}</td>
                                    <!-- <td>
                                        @if($l->status == 'proses')
                                        Proses
                                        @elseif($l->status == 'diterima')
                                        Diterima
                                        @elseif($l->status == 'ditolak')
                                        Ditolak
                                        @endif
                                    </td> -->

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
                                            <form action="{{ route('logbookReject', $l->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="flex items-center w-4 gap-1 text-3xl text-red-600 rounded-lg">
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                </button>
                                            </form>
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
