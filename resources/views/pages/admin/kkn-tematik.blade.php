<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <!-- Button to open "Tambah KKN" Modal -->
        <button type="button" data-bs-toggle="modal" data-bs-target="#tambahKKN"
            class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300">Tambah KKN Tematik</button>

        <!-- Table to display KKN Tematik -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">TAHUN</th>
                    <th scope="col">SEMESTER</th>
                    <th scope="col">KECAMATAN</th>
                    <th scope="col">KABUPATEN</th>
                    <th scope="col">TEMA</th>
                    <th scope="col">JUMLAH KELOMPOK</th>
                    <th scope="col">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tematiks as $tematik => $t)
                <tr>
                    <td>{{ $tematik + 1 }}</td>
                    <td>{{ $t->tahun }}</td>
                    <td>{{ $t->semester }}</td>
                    <td>{{ $t->lokasi }}</td>
                    <td>{{ $t->kecamatan }}</td>
                    <td>{{ $t->tema }}</td>
                    <td>{{ $t->padukuhans_count }}</td>
                    <td class="flex gap-2">
                        <a href="/padukuhan/{{ $t->id }}" type="submit"
                            class="p-2 text-black bg-yellow-400 rounded-lg"><i class="mr-1 fa-solid fa-eye"></i>View</a>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editKKN{{ $t->id }}"
                            class="p-2 text-black bg-blue-400 rounded-lg">Edit</button>

                        <!-- Delete Button -->
                        <button type="button" class="p-2 text-black bg-red-500 rounded-lg" data-bs-toggle="modal" data-bs-target="#deleteKKN{{ $t->id }}">Hapus</button>
                    </td>
                </tr>

                <!-- Modal Edit KKN -->
                <div class="modal fade" id="editKKN{{ $t->id }}" tabindex="-1" aria-labelledby="editKKNLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editKKNLabel">Edit KKN Tematik</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('editKknTematik', $t->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <input type="text" class="form-control" id="tahun" name="tahun" value="{{ $t->tahun }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <select class="form-control" id="semester" name="semester">
                                            <option value="Ganjil" {{ $t->semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                            <option value="Genap" {{ $t->semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="lokasi" class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $t->lokasi }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="kecamatan" class="form-label">Kabupaten</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $t->kecamatan }}">
                                    </div>

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

                <!-- Modal Delete KKN -->
                <div class="modal fade" id="deleteKKN{{ $t->id }}" tabindex="-1" aria-labelledby="deleteKKNLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteKKNLabel">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah Anda yakin ingin menghapus KKN Tematik ini?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{ route('deleteKknTematik', $t->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $tematiks->links() }}
    </div>

    <!-- Modal Tambah KKN -->
    <div class="modal fade" id="tambahKKN" tabindex="-1" aria-labelledby="tambahKKNLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKKNLabel">Tambah KKN Tematik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambahKkn') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="text" value="tematik" name="tipe" hidden>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="tahun" name="tahun">
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="text" class="form-control" id="semester" name="semester">
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi">
                        </div>

                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">Kabupaten</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan">
                        </div>

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
