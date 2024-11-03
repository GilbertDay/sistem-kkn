<x-app-layout>
    <div class="w-full h-full px-4 py-8 mx-auto overflow-y-auto sm:px-6 lg:px-8 max-w-9xl">
        <button type="button" data-bs-toggle="modal" data-bs-target="#tambahPadukuhans"
            class="p-2 mb-4 text-black bg-blue-400 rounded-lg hover:bg-slate-300">
            </button>

        <table class="table table-bordered">
            <thead >
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Padukuhan</th>
                    <th scope="col">APL</th>
                    <th scope="col">Telp APL</th>
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
                    <td>{{$p->desa}}</td>
                    <td>{{$p->apl}}</td>
                    <td>{{$p->telp_apl}}</td>
                    <td>{{$p->nama_dukuh}}</td>
                    <td>{{$p->telp_dukuh}}</td>
                    <td>{{$p->kelurahan}}</td>
                    <td >
                        <div class="pt-0.5 pb-2 px-3 mb-1 border-b border-gray-200 dark:border-gray-700/60">
                            <a href="/viewLogbook/{{ $p->id }}" type="submit"
                                class="p-2 text-black bg-yellow-400 rounded-lg"><i class="mr-1 fa-solid fa-eye"></i>Logbook</a>

                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>






</x-app-layout>
