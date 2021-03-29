<div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dasbor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-4 gap-10">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-md p-5 flex">
                <a href="{{ route('packet.show') }}" class="hover:underline">
                    <span class="block">Total Paket</span>
                </a>
                <span class="ml-auto text-5xl font-semibold text-gray-800">{{ $totalPacket }}</span>
            </div>
            <div class="bg-white overflow-hidden shadow-md sm:rounded-md p-5 flex">
                <a href="{{ route('transaction') }}" class="hover:underline">
                    <span class="block">Total Transaksi</span>
                </a>
                <span class="ml-auto text-5xl font-semibold text-gray-800">{{ $totalTrx }}</span>
            </div>
            <div class="bg-white overflow-hidden shadow-md sm:rounded-md p-5 flex">
                <a href="{{ route('user') }}" class="hover:underline">
                    <span class="block">Total Pengguna</span>
                </a>
                <span class="ml-auto text-5xl font-semibold text-gray-800">{{ $totalUser }}</span>
            </div>
            <div class="bg-white overflow-hidden shadow-md sm:rounded-md p-5 flex">
                <a href="{{ route('ticket.show') }}" class="hover:underline">
                    <span class="block">Total Tiket</span>
                </a>
                <span class="ml-auto text-5xl font-semibold text-gray-800">{{ $totalTicket }}</span>
            </div>
        </div>
    </div>

</div>