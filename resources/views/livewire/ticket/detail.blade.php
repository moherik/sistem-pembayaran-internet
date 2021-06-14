<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2 class="heading mr-auto mb-0">
                        {{ $ticket->title }}
                    </h2>
                    <span class="text-xs block">ID Tiket: {{ $ticket->id }}</span> | 
                    <span class="text-xs">Dibuat oleh <span class="font-semibold">{{ $ticket->user->name }}</span> pada {{ $ticket->created_at->format('h:i:s d-m-Y') }}</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dasbor</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ticket.show') }}">Daftar Tiket</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="py-12">
        <div class="container">
            <div class="card p-3">

                @foreach($conversations as $conversation)

                <div class="mb-6 d-inline {{ $conversation->type == 'TO' ? 'text-left' : 'text-right' }}">
                    <span class="text-xs">{{ $conversation->created_at->format('h:i:s d-m-y') }}</span>
                    <h5>{{ $conversation->body }}</h5>
                </div>

                @endforeach

                <form wire:submit.prevent="send">
                    <div class="mt-3">
                        <textarea wire:model="body" class="form-control" placeholder="Tulis sesuatu..."></textarea>
                        @error('body') <span class="text-xs mt-2">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 h-10">Kirim</button>
                </form>

            </div>
        </div>
    </div>

</div>