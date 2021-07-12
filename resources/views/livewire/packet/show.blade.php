<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 d-flex">
                    <h1>Daftar Paket</h1>
                    <a href="{{ route('packet.form', 'create') }}" class="ml-4 btn btn-primary">
                        Tambah
                    </a>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dasbor</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">

                <table class="table w-full">
                    <thead>
                        <th>No.</th>
                        <th>Nama Paket</th>
                        <th>Kecepatan</th>
                        <th>Tipe Paket</th>
                        <th>Harga</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse($this->packet as $packet)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $packet->name }}</td>
                            <td>{{ $packet->speedLabel() }}</td>
                            <td>{{ $packet->typeLabel() }}</td>
                            <td>{{ $packet->priceLabel() }}</td>
                            <td>
                                <a href="{{ route('packet.form', ['formType' => 'edit', 'packetId' => $packet->id]) }}" class="btn btn-primary btn-sm mr-2">Edit</a>
                                <button wire:click="confirmDelete({{ $packet->id }})" type="button" class="btn btn-danger btn-sm">Hapus</button>
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