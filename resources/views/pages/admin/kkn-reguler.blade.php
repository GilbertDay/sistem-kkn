<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <button type="button" data-bs-toggle="modal" data-bs-target="#tambahKKN"
            class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300">Tambah KKN Reguler</button>

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
                @foreach($regulers as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r->tahun }}</td>
                    <td>{{ $r->semester }}</td>
                    <td>{{ $r->lokasi }}</td>
                    <td>{{ $r->kecamatan }}</td>
                    <td>{{ $r->tema }}</td>
                    <td>{{ $r->padukuhans_count }}</td>
                    <td class="flex gap-2">
                        <a href="/padukuhan/{{ $r->id }}" class="p-2 text-black bg-yellow-400 rounded-lg">
                            <i class="mr-1 fa-solid fa-eye"></i>View
                        </a>
                        <!-- Edit Button triggers Edit Modal -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editKKN{{ $r->id }}" class="p-2 text-black bg-blue-400 rounded-lg">Edit</button>
                        
                        <!-- Delete Button triggers Delete Modal -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteKKN{{ $r->id }}" class="p-2 text-black bg-red-500 rounded-lg">Hapus</button>
                    </td>
                </tr>

                <!-- Modal Edit KKN -->
                <div class="modal fade" id="editKKN{{ $r->id }}" tabindex="-1" aria-labelledby="editKKNLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editKKNLabel">Edit KKN Reguler</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('kkn.update', $r->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <input type="text" value="reguler" name="tipe" hidden>
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <input type="text" class="form-control" id="tahun" name="tahun" value="{{ $r->tahun }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <select class="form-control" id="semester" name="semester">
                                            <option value="Ganjil" {{ $r->semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                            <option value="Genap" {{ $r->semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lokasi" class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $r->lokasi }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kecamatan" class="form-label">Kabupaten</label>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $r->kecamatan }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tema" class="form-label">Tema</label>
                                        <input type="text" class="form-control" id="tema" name="tema" value="{{ $r->tema }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus KKN -->
                <div class="modal fade" id="deleteKKN{{ $r->id }}" tabindex="-1" aria-labelledby="deleteKKNLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteKKNLabel">Hapus KKN Reguler</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('kkn.destroy', $r->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus KKN ini?</p>
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
        {{ $regulers->links() }}
    </div>

    <!-- Modal Tambah KKN -->
    <div class="modal fade" id="tambahKKN" tabindex="-1" aria-labelledby="tambahKKNLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKKNLabel">Tambah KKN Reguler</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tambahKkn') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="text" value="reguler" name="tipe" hidden>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="tahun" name="tahun">
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-control" id="semester" name="semester">
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
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
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
