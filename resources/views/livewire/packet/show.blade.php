<div>

    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="heading mr-auto">Daftar Paket</h2>
            <a href="{{ route('packet.form', 'create') }}" class="btn btn-blue">
                Tambah
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card">

                <table class="table w-full">
                    <thead>
                        <th class="w-1">No.</th>
                        <th>Nama Paket</th>
                        <th class="w-1/6">Harga</th>
                        <th class="w-1/6">Kecepatan</th>
                        <th class="w-1/6">Tipe Paket</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse($this->packet as $packet)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-semibold">{{ $packet->name }}</td>
                            <td>{{ $packet->priceLabel() }}</td>
                            <td>{{ $packet->speedLabel() }}</td>
                            <td>{{ $packet->typeLabel() }}</td>
                            <td>
                                <div class="flex">
                                    <a href="{{ route('packet.form', ['formType' => 'edit', 'packetId' => $packet->id]) }}" class="btn btn-blue mr-2">Edit</a>
                                    <button wire:click="confirmDelete({{ $packet->id }})" type="button" class="btn btn-red">Hapus</button>
                                </div>
                            </td>
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