<div>

  <x-slot name="header">
    <h2 class="heading mr-auto">Daftar Tiket</h2>
  </x-slot>

  <div class="py-12">
    <div class="container">
      <div class="card">

        <table class="table w-full">
          <thead>
            <th class="w-1">No.</th>
            <th>Nama Pengguna</th>
            <th class="w-1/6">Judul</th>
            <th class="w-1/6">Status</th>
            <th class="w-1/6">Waktu</th>
            <th></th>
          </thead>
          <tbody>
            @forelse($this->ticket as $ticket)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td class="font-semibold">
                <a href="{{ route('ticket.detail', $ticket->id) }}" class="hover:underline text-blue-600">
                  {{ $ticket->user->name }}
                </a>
              </td>
              <td>{{ $ticket->title }}</td>
              <td>{!! $ticket->statusLabel() !!}</td>
              <td>{{ $ticket->created_at->format('d-m-Y') }}</td>
              <td>
                <div class="flex">
                  <a href="{{ route('ticket.detail', $ticket->id) }}" class="btn btn-blue mr-2">Detail</a>
                  <button wire:click="confirmDelete({{ $ticket->id }})" type="button" class="btn btn-red">Hapus</button>
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