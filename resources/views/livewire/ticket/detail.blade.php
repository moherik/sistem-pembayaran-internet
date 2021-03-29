<div>

    <x-slot name="header">
        <div class="flex items-center">
            <div class="border-blue-500 border-l-8 pl-4 mr-auto">
                <h2 class="heading mr-auto">
                    {{ $ticket->title }}
                </h2>
                <span class="text-xs block">ID Tiket: {{ $ticket->id }}</span>
                <span class="text-xs">Dibuat oleh <span class="font-semibold">{{ $ticket->user->name }}</span> pada {{ $ticket->created_at->format('h:i:s d-m-Y') }}</span>
            </div>

            <span class="text-sm text-gray-600 font-medium">
                <a class="hover:text-blue-500" href="{{ route('ticket.show') }}">Daftar Tiket</a>
                <span class="px-2">/</span>
                <span class="font-semibold">Chat</span>
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="card p-10">

                @foreach($conversations as $conversation)

                <div class="mb-6 border-l-8 {{ $conversation->type == 'TO' ? 'border-blue-500' : 'border-red-500' }} pl-4">
                    <span class="text-xs text-gray-600">{{ $conversation->created_at->format('h:i:s d-m-y') }}</span>
                    <div>{{ $conversation->body }}</div>
                </div>

                @endforeach

                <form wire:submit.prevent="send">
                    <div class="w-1/3">
                        <textarea wire:model="body" class="input h-20 w-full" placeholder="Tulis sesuatu..."></textarea>
                        @error('body') <span class="text-xs text-red-600 mt-2">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-blue mt-4 h-10">Kirim</button>
                </form>

            </div>
        </div>
    </div>

</div>