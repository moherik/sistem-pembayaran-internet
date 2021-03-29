<div>

    <x-slot name="header">
        <h2 class="heading mr-auto">Daftar Pengguna</h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card">

                <table class="table w-full">
                    <thead>
                        <th class="w-1">No.</th>
                        <th>Nama</th>
                        <th class="w-1/6">Email</th>
                        <th class="w-1/6">No. Telp</th>
                        <th class="w-1/6">Paket Aktif</th>
                    </thead>
                    <tbody>
                        @forelse($this->user as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>{{ $user->packetDetail() }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>