<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <!-- Button to trigger Add KKN Modal -->
        <button type="button" data-bs-toggle="modal" data-bs-target="#tambahKKNReguler"
            class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300">Tambah KKN Reguler</button>

        <!-- Table to display KKN Reguler data -->
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
                @foreach($regulers as $reguler => $r)
                <tr>
                    <td>{{ $reguler + 1 }}</td>
                    <td>{{ $r->tahun }}</td>
                    <td>{{ $r->semester }}</td>
                    <td>{{ $r->lokasi }}</td>
                    <td>{{ $r->kecamatan }}</td>
                    <td>{{ $r->tema }}</td>
                    <td>{{ $r->padukuhans_count }}</td>
                    <td class="flex gap-2">
                        <!-- View Button -->
                        <a href="/padukuhan/{{ $r->id }}" class="p-2 text-black bg-yellow-400 rounded-lg">
                            <i class="mr-1 fa-solid fa-eye"></i>View
                        </a>
                        <!-- Edit Button triggers modal -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editRegulerModal{{ $r->id }}"
                            class="p-2 text-black bg-blue-400 rounded-lg">Edit</button>
                        <!-- Delete Button triggers modal -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteRegulerModal{{ $r->id }}"
                            class="p-2 text-black bg-red-500 rounded-lg">Hapus</button>
                    </td>
                </tr>

                <!-- Modal for Edit KKN -->
                <div class="modal fade" id="editRegulerModal{{ $r->id }}" tabindex="-1" aria-labelledby="editRegulerLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editRegulerLabel">Edit KKN Reguler</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('editKkn', $r->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <!-- Year Input -->
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <input type="text" class="form-control" id="tahun" name="tahun" value="{{ $r->tahun }}">
                                    </div>
                                    <!-- Semester Input (Gasal / Genap) -->
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <select class="form-control" id="semester" name="semester">
                                            <option value="Gasal" {{ $r->semester == 'Gasal' ? 'selected' : '' }}>Gasal</option>
                                            <option value="Genap" {{ $r->semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                                        </select>
                                    </div>
                                    <!-- Location Input -->
                                    <div class="mb-3">
                                        <label for="lokasi" class="form-label">Kabupaten</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $r->lokasi }}">
                                    </div>
                                    <!-- Kecamatan Input -->
                                    <div class="mb-3">
                                        <label for="kecamatan" class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $r->kecamatan }}">
                                    </div>
                                    <!-- Tema Input -->
                                    <div class="mb-3">
                                        <label for="tema" class="form-label">Tema</label>
                                        <input type="text" class="form-control" id="tema" name="tema" value="{{ $r->tema }}">
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
                <div class="modal fade" id="deleteRegulerModal{{ $r->id }}" tabindex="-1" aria-labelledby="deleteRegulerLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteRegulerLabel">Hapus KKN Reguler</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus data KKN ini?
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('deleteKkn', $r->id) }}" method="POST">
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

        <!-- Pagination for Reguler Data -->
        {{ $regulers->links() }}
    </div>

    <!-- Modal for Adding KKN -->
    <div class="modal fade" id="tambahKKNReguler" tabindex="-1" aria-labelledby="tambahKKNRegulerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKKNRegulerLabel">Tambah KKN Reguler</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambahKkn') }}" method="POST">
                    @csrf
                    <input type="text" value="reguler" name="tipe" hidden>
                    <div class="modal-body">
                        <!-- Year Input -->
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="tahun" name="tahun">
                        </div>
                        <!-- Semester Input (Gasal / Genap) -->
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-control" id="semester" name="semester">
                                <option value="Gasal">Gasal</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <!-- Location Input -->
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">KABUPATEN</label>
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
