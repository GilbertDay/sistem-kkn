<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <div class="flex flex-col gap-6">
            @foreach($logbooks as $userId => $logbook)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="text-xl font-semibold text-white bg-gray-600 py-4 px-6">
                    Logbook {{ $logbook->first()->user->name . ' (' . $logbook->first()->user->nim . ')' }}
                </div>

                <!-- Table -->
                <div class="p-6 bg-gray-100">
                    <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                        <thead class="bg-gray-700 text-white">
                            <tr>
                                <th scope="col" class="py-3 px-4 text-left font-medium">No</th>
                                <th scope="col" class="py-3 px-4 text-left font-medium">Kegiatan</th>
                                <th scope="col" class="py-3 px-4 text-left font-medium">Tanggal</th>
                                <th scope="col" class="py-3 px-4 text-left font-medium">Catatan</th>
                                <th scope="col" class="py-3 px-4 text-left font-medium">Status</th>
                                <th scope="col" class="py-3 px-4 text-left font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logbook as $l)
                            <tr class="border-t border-gray-300 hover:bg-gray-100 transition-colors">
                                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4">{{ $l->kegiatan }}</td>
                                <td class="py-3 px-4">{{ $l->tanggal }}</td>
                                <td class="py-3 px-4">{{ $l->catatan }}</td>
                                <td class="py-3 px-4">
                                    @if($l->status == 'proses')
                                    <span class="text-yellow-500 font-semibold">Proses</span>
                                    @elseif($l->status == 'diterima')
                                    <span class="text-green-500 font-semibold">Diterima</span>
                                    @elseif($l->status == 'ditolak')
                                    <span class="text-red-500 font-semibold">Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 space-x-2">
                                    <!-- Accept Logbook Button -->
                                    <form action="{{ route('logbook.accept', $l->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="p-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">Terima</button>
                                    </form>
                                    <!-- Reject Logbook Button -->
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalTolak{{ $l->id }}" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">Tolak</button>
                                </td>
                            </tr>

                            <!-- Modal for Rejection Confirmation -->
                            <div class="modal fade" id="modalTolak{{ $l->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $l->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel{{ $l->id }}">Tolak Logbook</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menolak logbook ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('logbook.reject', $l->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
