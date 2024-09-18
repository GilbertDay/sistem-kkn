<x-app-layout>
    <div class="w-full px-4 py-8 mx-auto sm:px-6 lg:px-8 max-w-9xl">
        <button type="button" data-bs-toggle="modal" data-bs-target="#tambahKelompoks"
            class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300">Tambah Kelompok</button>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Kelompok</th>
                    <th scope="col">Nama Padukuhan</th>
                    <th scope="col">Ketua Kelompok</th>
                    <th scope="col">Tanggal Mulai</th>
                    <th scope="col">Tanggal Selesai</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelompoks as $kelompok => $k)
                <tr>
                    <td>{{ $kelompok + 1 }}</td>
                    <td>{{ $k->nama_kelompok }}</td>
                    <td>{{ $k->padukuhan->lokasi }}</td>
                    <td>{{ $k->users->name }}</td>
                    <td>{{ $k->tanggal_mulai }}</td>
                    <td>{{ $k->tanggal_selesai }}</td>
                    <td>
                        <a type="button" class="p-2 text-black bg-yellow-400 rounded-lg"><i
                                class="mr-1 fa-solid fa-eye"></i>View</a>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#editKelompoks{{ $k->id }}"
                            class="p-2 text-black bg-blue-400 rounded-lg">Edit</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#hapusKelompoks{{ $k->id }}"
                            class="p-2 text-black bg-red-500 rounded-lg">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $kelompoks->links() }}
    </div>

    <!-- Modal Tambah Kelompok -->
    <div class="modal fade" id="tambahKelompoks" tabindex="-1" aria-labelledby="tambahKelompoksLabel"
        aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKelompoksLabel">Tambah Kelompok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addKelompoks') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kelompok" class="form-label">Nama Kelompok</label>
                            <input type="text" class="form-control" id="nama_kelompok" name="nama_kelompok">
                        </div>
                        <div class="mb-3">
                            <label for="padukuhan_id" class="form-label">Padukuhan</label>
                            <select class="form-select" id="padukuhan_id" name="padukuhan_id">
                                @foreach($padukuhan as $p)
                                <option value="{{ $p->id }}">{{ $p->lokasi }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ketua_id" class="form-label">Ketua Kelompok</label>
                            <select class="form-select" id="ketua_id" name="ketua_id">
                                @foreach($siswa as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="siswa-search" class="form-label">Anggota Kelompok</label>
                            <select id="siswa-search" name="siswa-search" class="w-full"></select>
                            <div class="mt-2" id="selected-tags"></div>
                            <!-- Input tersembunyi untuk menyimpan ID anggota yang dipilih -->
                            <input type="hidden" id="selected_ids" name="selected_ids">
                        </div>

                        <div class="flex flex-col mb-3">
                            <label for="start_date" class="mb-2">Tanggal Mulai:</label>
                            <input type="date" id="start_date" name="start_date" required>
                        </div>
                        <div class="flex flex-col mb-3">
                            <label for="end_date" class="mb-2">Tanggal Selesai:</label>
                            <input type="date" id="end_date" name="end_date" required>
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

    <!-- Modal Update Kelompok -->
    @foreach($kelompoks as $k)
    <div class="modal fade" id="editKelompoks{{ $k->id }}" tabindex="-1"
        aria-labelledby="editKelompoksLabel{{ $k->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKelompoksLabel{{ $k->id }}">Update Kelompok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('editKelompoks', $k->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kelompok_edit{{ $k->id }}" class="form-label">Nama Kelompok</label>
                            <input type="text" class="form-control" id="nama_kelompok_edit{{ $k->id }}"
                                name="nama_kelompok" value="{{ $k->nama_kelompok }}">
                        </div>
                        <div class="mb-3">
                            <label for="padukuhan_id_edit{{ $k->id }}" class="form-label">Padukuhan</label>
                            <select class="form-select" id="padukuhan_id_edit{{ $k->id }}" name="padukuhan_id">
                                @foreach($padukuhan as $p)
                                <option value="{{ $p->id }}" {{ $p->id == $k->padukuhan_id ? 'selected' : '' }}>
                                    {{ $p->lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="siswa-search-edit{{ $k->id }}" class="form-label">Anggota Kelompok</label>
                            <select id="siswa-search-edit{{ $k->id }}" name="dosen_id" class="w-full"></select>
                            <div class="mt-2" id="selected-tags-edit{{ $k->id }}"></div>
                            <!-- Input tersembunyi untuk menyimpan ID anggota yang dipilih -->
                            <input type="hidden" id="selected_ids_edit{{ $k->id }}" name="selected_ids">
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
    @endforeach

    <script>
        var myModal = new bootstrap.Modal(document.getElementById('tambahKelompoks'), {
            keyboard: false,
            focus: false
        })

    </script>
    <script>
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        // Event listener untuk memperbarui minimal tanggal selesai
        startDateInput.addEventListener('change', function () {
            const startDate = new Date(this.value);
            const minEndDate = new Date(startDate);
            minEndDate.setDate(minEndDate.getDate() +
                1); // Minimal tanggal selesai adalah 1 hari setelah tanggal mulai
            const formattedMinEndDate = minEndDate.toISOString().split('T')[0]; // Format ke YYYY-MM-DD

            endDateInput.min = formattedMinEndDate;
            // Reset nilai input tanggal selesai jika kurang dari tanggal minimal
            if (endDateInput.value < formattedMinEndDate) {
                endDateInput.value = '';
            }
        });

    </script>


    <script>
        // Initialize Select2 for Add Modal
        $('#tambahKelompoks').on('shown.bs.modal', function () {
            var selectedIds = [];

            $('#siswa-search').select2({
                placeholder: 'Cari Users...',
                minimumInputLength: 0,
                ajax: {
                    url: "{{ route('searchUsers') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function (data) {
                        var results = data.filter(function (item) {
                            return !selectedIds.includes(item.id);
                        }).map(function (item) {
                            return {
                                id: item.id,
                                text: item.name
                            };
                        });

                        return {
                            results: results
                        };
                    },
                    cache: true
                }
            });

            $('#siswa-search').on('select2:select', function (e) {
                var selectedData = e.params.data;
                selectedIds.push(selectedData.id);
                addTag(selectedData);
                $('#siswa-search').val(null).trigger('change');
                updateSelectedIdsField();
            });

            function addTag(data) {
                var tagHtml = '<span class="px-2 text-black bg-green-400 rounded-2xl tag">' + data
                    .text +
                    ' <a href="#" class="remove-tag" data-id="' + data.id + '">×</a></span>';
                $('#selected-tags').append(tagHtml);
            }

            $('#selected-tags').on('click', '.remove-tag', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                selectedIds = selectedIds.filter(function (selectedId) {
                    return selectedId !== id;
                });
                $(this).parent().remove();
                $('#siswa-search').val(null).trigger('change');
                updateSelectedIdsField();
            });

            function updateSelectedIdsField() {
                $('#selected_ids').val(selectedIds.join(','));
            }
        });

    </script>

    <!-- Add z-index fix -->
    <style>
        .select2-container--open {
            z-index: 9999;
        }

        .select2-dropdown {
            z-index: 9999;
        }

        .select2-search__field {
            z-index: 9999;
        }

    </style>
</x-app-layout>
