<div>

    <x-slot name="header">
        <h2 class="heading mr-auto">Daftar Transaksi</h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
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
                                <div class="flex">
                                    <button wire:click="confirmStatus({{ $transaction->id }}, 'SUCCESS')" type="button" class="btn btn-blue mr-2">Sukses</button>
                                    <button wire:click="confirmStatus({{ $transaction->id }}, 'PENDING')" type="button" class="btn btn-black">Pending</button>
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