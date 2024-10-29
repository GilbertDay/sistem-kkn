<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">




        <div class="card laporan-tabel" id="laporan-masuk">
            <div class="text-xl text-white bg-gray-400 card-header">Daftar User</div>
            <div class="card-body">
                <div class="flex items-center justify-between w-full gap-4 mb-3">
                    <div class="w-1/2">
                        <label for="roleFilter" class="form-label">Filter by Role</label>
                        <select id="roleFilter" class="form-select">
                            <option value="all">All</option>
                            <option value="User">User</option>
                            <option value="Dosen">Dosen</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#tambahUsers"
                        class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300">Tambah
                        User</button>

                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Terakhir Diubah</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user=>$u)
                        <tr data-role="{{$u->type == 0 ? 'User' :( $u->type == 1 ? 'Dosen' : 'Admin')}}">
                            <td>{{ $user + 1 }}</td>
                            <td>{{$u->name}}</td>
                            <td>{{$u->email}}</td>
                            <td>{{$u->updated_at}}</td>
                            <td>{{$u->type == 0 ? 'User' :( $u->type == 1 ? 'Dosen' : 'Admin')}}</td>
                            <td>
                                <!-- <a type="button" class="p-2 text-black bg-yellow-400 rounded-lg"><i
                                        class="mr-1 fa-solid fa-eye"></i>View</a> -->
                                <button type="button" data-bs-toggle="modal" data-bs-target="#editUsers{{$u->id}}"
                                    class="p-2 text-black bg-yellow-400 rounded-lg">Edit</button>
                                <!-- Trigger the modal with a button -->
                                <button type="button" data-bs-toggle="modal" data-bs-target="#hapusUsers{{ $u->id }}"
                                    class="p-2 text-black bg-red-500 rounded-lg">Hapus</button>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="tambahUsers" tabindex="-1" aria-labelledby="tambahUsersLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahUsersLabel">Tambah Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addUsers') }}" method="POST">
                    <div class="modal-body">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Jenis User</label>
                            <select class="form-select" id="role" name="role">
                                <option value="0">User</option>
                                <option value="1">Dosen</option>
                                <option value="2">Admin</option>
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

    @foreach ($users as $u)
    <div class="modal fade" id="editUsers{{$u->id}}" tabindex="-1" aria-labelledby="editUsersLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUsersLabel">Edit Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editUsers') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="text" class="form-control" id="id" name="id" value="{{$u->id}}" hidden>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$u->name}}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{$u->email}}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    value="{{$u->plain_password}}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Jenis User</label>
                            <select class="form-select" id="role" name="role">
                                <option value="0">User</option>
                                <option value="1">Dosen</option>
                                <option value="2">Admin</option>
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

    <div class="modal fade" id="hapusUsers{{$u->id}}" tabindex="-1" aria-labelledby="hapusUsersLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusUsersLabel">Hapus Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('hapusUsers') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="text" class="form-control" id="id" name="id" value="{{$u->id}}" hidden>
                        <p>Apakah anda yakin ingin menghapus user ini?</p>
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

    <script>
        document.getElementById('roleFilter').addEventListener('change', function () {
            const selectedRole = this.value;
            const rows = document.querySelectorAll('table tbody tr');
            let rowCount = 0; // Initialize row count

            rows.forEach(row => {
                const role = row.getAttribute('data-role');

                if (selectedRole === 'all' || role === selectedRole) {
                    row.style.display = '';
                    rowCount++;
                    row.querySelector('td:first-child').textContent = rowCount; // Update "No" column
                } else {
                    row.style.display = 'none';
                }
            });
        });

    </script>

</x-app-layout>
