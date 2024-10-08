<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <button type="button" data-bs-toggle="modal" data-bs-target="#tambahPadukuhans"
            class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300">Tambah
            Padukuhan</button>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Dukuh</th>
                    <th scope="col">Desa</th>
                    <th scope="col">Asisten</th>
                    <th scope="col">Dosen Pembimbing</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($padukuhans as $padukuhan=>$p)
                <tr>
                    <td>{{ $padukuhan + 1 }}</td>
                    <td>{{$p->nama_dukuh}}</td>
                    <td>{{$p->desa}}</td>
                    <td>{{$p->apl}}</td>
                    <td>{{$p->users->name}}</td>
                    <td>
                        <a href="/kelompok/{{ $p->id }}" type="submit"
                            class="p-2 text-black bg-yellow-400 rounded-lg"><i class="mr-1 fa-solid fa-eye"></i>View</a>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editPadukuhans{{$p->id}}"
                            class="p-2 text-black bg-blue-400 rounded-lg">Edit</button>
                        <!-- Trigger the modal with a button -->
                        <button type="button" data-bs-toggle="modal" data-bs-target="#hapusPadukuhans{{ $p->id }}"
                            class="p-2 text-black bg-red-500 rounded-lg">Hapus</button>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
        {{ $padukuhans->links() }}
    </div>


    <!-- Modal -->
    <div class="modal fade" id="tambahPadukuhans" tabindex="-1" aria-labelledby="tambahPadukuhansLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPadukuhansLabel">Tambah Padukuhan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addPadukuhans') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="text" value="{{$kkn_id}}" name="kkn_id" hidden>
                        <div class="mb-3">
                            <label for="dukuh" class="form-label">Nama Dukuh</label>
                            <input type="text" class="form-control" id="dukuh" name="dukuh">
                        </div>

                        <div class="mb-3">
                            <label for="desa" class="form-label">Desa</label>
                            <input type="text" class="form-control" id="desa" name="desa">
                        </div>

                        <div class="mb-3 ">
                            <label for="apl" class="form-label">Nama Asisten Lapangan</label>
                            <input type="text" class="form-control" id="apl" name="apl">
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Dosen Pembimbing</label>
                            <select class="form-select" id="dosenpembimbing" name="dosen_id">
                                @foreach($dosen as $d)
                                <option value="{{$d->id}}">{{$d->name}}</option>
                                @endforeach
                            </select>
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

    @foreach ($padukuhans as $p)
    <!-- Modal -->
    <div class="modal fade" id="editPadukuhans{{$p->id}}" tabindex="-1" aria-labelledby="editPadukuhansLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPadukuhansLabel">Edit Padukuhan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editPadukuhans') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="text" class="form-control" id="id" name="id" value="{{$p->id}}" hidden>
                        <input type="text" name="kkn_id" value="{{$kkn_id}}" hidden>

                        <div class="mb-3">
                            <label for="dukuh" class="form-label">Nama Dukuh</label>
                            <input type="text" class="form-control" id="dukuh" name="dukuh" value="{{$p->nama_dukuh}}">
                        </div>

                        <div class="mb-3">
                            <label for="desa" class="form-label">Desa</label>
                            <input type="text" class="form-control" id="desa" name="desa" value="{{$p->desa}}">
                        </div>
                        <div class="mb-3">
                            <label for="apl" class="form-label">Nama Asisten Lapangan</label>
                            <input type="text" class="form-control" id="apl" name="apl" value="{{$p->apl}}">
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Dosen Pembimbing</label>
                            <select class="form-select" id="dosenpembimbing" name="dosen_id">
                                @foreach($dosen as $d)
                                <option value="{{$d->id}}">{{$d->name}}</option>
                                @endforeach
                            </select>
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

    <div class="modal fade" id="hapusPadukuhans{{$p->id}}" tabindex="-1" aria-labelledby="hapusPadukuhansLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusPadukuhansLabel">Hapus Padukuhans</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('hapusPadukuhans') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="text" class="form-control" id="id" name="id" value="{{$p->id}}" hidden>
                        <p>Apakah anda yakin ingin menghapus Desa {{$p->desa}}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endforeach





</x-app-layout>
