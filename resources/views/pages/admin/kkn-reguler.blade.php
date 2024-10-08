<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <button type="button" data-bs-toggle="modal" data-bs-target="#tambahKKN"
            class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300">Tambah KKN Reguler</button>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tahun</th>
                    <th scope="col">Semester</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Kecamatan</th>
                    <th scope="col">Jumlah Kelompok</th>
                    <th scope="col">Aksi</th>
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
                    <td>{{ $r->padukuhans_count }}</td>
                    <td class="flex gap-2">
                        <a href="/padukuhan/{{ $r->id }}" type="submit"
                            class="p-2 text-black bg-yellow-400 rounded-lg"><i class="mr-1 fa-solid fa-eye"></i>View</a>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#"
                            class="p-2 text-black bg-blue-400 rounded-lg">Edit</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#"
                            class="p-2 text-black bg-red-500 rounded-lg">Hapus</button>
                    </td>
                </tr>
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
                    <div class="modal-body">
                        @csrf
                        <input type="text" value="reguler" name="tipe" hidden>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="tahun" name="tahun">
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="text" class="form-control" id="semester" name="semester">
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi">
                        </div>

                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
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
