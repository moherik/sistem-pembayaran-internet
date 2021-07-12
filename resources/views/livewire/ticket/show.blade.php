<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Daftar Pengaduan</h1>
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
                <a href="{{ route('ticket.detail', $ticket->id) }}" class="btn btn-primary btn-sm mr-2">Detail</a>
                <button wire:click="confirmDelete({{ $ticket->id }})" type="button" class="btn btn-danger btn-sm">Hapus</button>
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