<x-app-layout>
    <div class="w-full h-full px-4 py-8 mx-auto overflow-y-auto sm:px-6 lg:px-8 max-w-9xl">
        <button type="button" data-bs-toggle="modal" data-bs-target="#tambahPadukuhans"
            class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300">Tambah
            Padukuhan</button>

        <table class="table table-bordered">
            <thead >
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">DPL</th>
                    <th scope="col">Telp DPL</th>
                    <th scope="col">APL</th>
                    <th scope="col">Telp APL</th>
                    <th scope="col">Padukuhan</th>
                    <th scope="col">Nama Dukuh</th>
                    <th scope="col">Telp Dukuh</th>
                    <th scope="col">Kelurahan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($padukuhans as $padukuhan=>$p)
                <tr>
                    <td>{{ $padukuhan + 1 }}</td>
                    <td>{{$p->users->name}}</td>
                    <td>{{$p->users->no_telp}}</td>
                    <td>{{$p->apl}}</td>
                    <td>{{$p->telp_apl}}</td>
                    <td>{{$p->desa}}</td>
                    <td>{{$p->nama_dukuh}}</td>
                    <td>{{$p->telp_dukuh}}</td>
                    <td>{{$p->kelurahan}}</td>
                    <td >
                        <div class="relative inline-flex p-2.5 rounded-xl  bg-yellow-300" x-data="{ open: false }">
                            <button class="inline-flex items-center justify-center group" aria-haspopup="true" @click.prevent="open = !open"
                                :aria-expanded="open">
                                <div class="flex items-center truncate">
                                    <span
                                        class="ml-2 text-sm font-medium text-black">Action</span>
                                    <svg class="w-3 h-3 ml-1 text-black fill-current shrink-0 dark:text-black" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </button>

                            <div class="origin-top-right z-10 absolute top-full min-w-44 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700/60 py-1.5 rounded-lg shadow-lg overflow-hidden mt-1 right-0"
                            @click.outside="open = false" @keydown.escape.window="open = false" x-show="open"
                            x-transition:enter="transition ease-out duration-200 transform"
                            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-out duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" x-cloak>
                                <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-gray-200 dark:border-gray-700/60">
                                    <a href="/kelompok/{{ $p->id }}" type="submit"
                                        class="p-2 text-black bg-yellow-400 rounded-lg"><i class="mr-1 fa-solid fa-eye"></i>View</a>

                                </div>
                                <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-gray-200 dark:border-gray-700/60">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editPadukuhans{{$p->id}}"
                                        class="p-2 text-black bg-blue-400 rounded-lg">Edit</button>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#hapusPadukuhans{{ $p->id }}"
                                            class="p-2 text-black bg-red-500 rounded-lg">Hapus</button>
                                </div>
                            </div>
                        </div>

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

                        <div class="mb-3 ">
                            <label for="apl" class="form-label">Telp Dukuh</label>
                            <input type="text" class="form-control" id="telp_dukuh" name="telp_dukuh">
                        </div>

                        <div class="mb-3">
                            <label for="desa" class="form-label">Padukuhan</label>
                            <input type="text" class="form-control" id="padukuhan" name="padukuhan">
                        </div>

                        <div class="mb-3">
                            <label for="desa" class="form-label">Kelurahan</label>
                            <input type="text" class="form-control" id="kelurahan" name="kelurahan">
                        </div>

                        <div class="mb-3 ">
                            <label for="apl" class="form-label">Nama Asisten Lapangan</label>
                            <input type="text" class="form-control" id="apl" name="apl">
                        </div>

                        <div class="mb-3 ">
                            <label for="apl" class="form-label">Telp Asisten Lapangan</label>
                            <input type="text" class="form-control" id="telp_apl" name="telp_apl">
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
