<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Transaksi</h1>
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
                        <th class="w-1">No.</th>
                        <th>Nama Pengguna</th>
                        <th class="w-1/4">Paket</th>
                        <th class="w-1/6">Tanggal Transaksi</th>
                        <th class="w-1/6" colspan="2">Status Pembayaran</th>
                    </thead>
                    <tbody>
                        @forelse($this->transaction as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="font-semibold">{{ $transaction->user->name }}</td>
                            <td>
                                <div class="font-bold">{{ $transaction->priceLabel() }}</div>
                                {{ $transaction->packetLabel() }}
                            </td>
                            <td>{{ $transaction->createdDate() }}</td>
                            <td>{!! $transaction->statusLabel() !!}</td>
                            <td>
                                <button wire:click="confirmStatus({{ $transaction->id }}, 'SUCCESS')" type="button" class="btn btn-primary btn-sm mr-2">Sukses</button>
                                <button wire:click="confirmStatus({{ $transaction->id }}, 'PENDING')" type="button" class="btn btn-secondary btn-sm">Pending</button>
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