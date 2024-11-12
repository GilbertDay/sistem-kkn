<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <!-- Button to trigger Add KKN Modal -->
        <button type="button" data-bs-toggle="modal" data-bs-target="#tambahKKNTematik"
            class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300">Tambah KKN Tematik</button>

        <!-- Table to display KKN Tematik data -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">TAHUN</th>
                    <th scope="col">SEMESTER</th>
                    <th scope="col">KABUPATEN</th>
                    <th scope="col">KECAMATAN</th>
                    <th scope="col">TEMA</th>
                    <th scope="col">JUMLAH KELOMPOK</th>
                    <th scope="col">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tematiks as $key => $t)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $t->tahun }}</td>
                    <td>{{ $t->semester }}</td>
                    <td>{{ $t->lokasi }}</td>
                    <td>{{ $t->kecamatan }}</td>
                    <td>{{ $t->tema }}</td>
                    <td>{{ $t->padukuhans_count }}</td>
                    <td class="flex gap-2">
                        <!-- View Button -->
                        <a href="/padukuhan/{{ $t->id }}" class="p-2 text-black bg-yellow-400 rounded-lg">
                            <i class="mr-1 fa-solid fa-eye"></i>View
                        </a>
                        <!-- Edit Button triggers modal -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editTematikModal{{ $t->id }}"
                            class="p-2 text-black bg-blue-400 rounded-lg">Edit</button>
                        <!-- Delete Button triggers modal -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteTematikModal{{ $t->id }}"
                            class="p-2 text-black bg-red-500 rounded-lg">Hapus</button>
                    </td>
                </tr>

                <!-- Modal for Edit KKN -->
                <div class="modal fade" id="editTematikModal{{ $t->id }}" tabindex="-1" aria-labelledby="editTematikLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editTematikLabel">Edit KKN Tematik</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('updateKkn', $t->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <!-- Year Input -->
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <input type="text" class="form-control" id="tahun" name="tahun" value="{{ $t->tahun }}">
                                    </div>
                                    <!-- Semester Input -->
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <input type="text" class="form-control" id="semester" name="semester" value="{{ $t->semester }}">
                                    </div>
                                    <!-- Location Input -->
                                    <div class="mb-3">
                                        <label for="lokasi" class="form-label">Kabupaten</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $t->lokasi }}">
                                    </div>
                                    <!-- Kecamatan Input -->
                                    <div class="mb-3">
                                        <label for="kecamatan" class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $t->kecamatan }}">
                                    </div>
                                    <!-- Tema Input -->
                                    <div class="mb-3">
                                        <label for="tema" class="form-label">Tema</label>
                                        <input type="text" class="form-control" id="tema" name="tema" value="{{ $t->tema }}">
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

                <!-- Modal for Delete KKN -->
                <div class="modal fade" id="deleteTematikModal{{ $t->id }}" tabindex="-1" aria-labelledby="deleteTematikLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteTematikLabel">Hapus KKN Tematik</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus data KKN ini?
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('deleteKkn', $t->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination for Tematik Data -->
        {{ $tematiks->links() }}
    </div>

    <!-- Modal for Adding KKN -->
    <div class="modal fade" id="tambahKKNTematik" tabindex="-1" aria-labelledby="tambahKKNTematikLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKKNTematikLabel">Tambah KKN Tematik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambahKkn') }}" method="POST">
                    @csrf
                    <input type="text" value="tematik" name="tipe" hidden>
                    <div class="modal-body">
                        <!-- Year Input -->
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="tahun" name="tahun">
                        </div>
                        <!-- Semester Input -->
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="text" class="form-control" id="semester" name="semester">
                        </div>
                        <!-- Location Input -->
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi">
                        </div>
                        <!-- Kecamatan Input -->
                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan">
                        </div>
                        <!-- Tema Input -->
                        <div class="mb-3">
                            <label for="tema" class="form-label">Tema</label>
                            <input type="text" class="form-control" id="tema" name="tema">
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
</x-app-layout>
