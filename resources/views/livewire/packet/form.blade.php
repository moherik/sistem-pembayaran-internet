<div>

    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="heading mr-auto">{{ $label }}</h2>
            <span class="text-sm text-gray-600 font-medium">
                <a class="hover:text-blue-500" href="{{ route('packet.show') }}">Daftar Paket</a>
                <span class="px-2">/</span>
                <span class="font-semibold">{{ $label }}</span>
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container">

            @if($alertText != "")
            <div class="mb-4">
                <x-alert type="{{ $alertType }}">{{ $alertText }}</x-alert>
            </div>
            @endif

            <div class="card pt-10 pb-5">
                <form class="form" wire:submit.prevent="savePacket">
                    <div class="form-item">
                        <div class="label">Nama</div>
                        <div class="w-1/2">
                            <input type="text" wire:model="name" placeholder="Nama Paket" class="input w-full" />
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-item">
                        <div class="label">Harga</div>
                        <div class="w-1/2">
                            <input type="text" wire:model="price" placeholder="Harga Paket" class="input w-1/2" />
                            @error('price') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-item">
                        <div class="label">Kecepatan</div>
                        <div class="w-1/2">
                            <div class="flex items-center">
                                <input type="text" wire:model="speed" placeholder="100" class="input w-1/4" />
                                <span class="ml-2 text-gray-800">Mbps</span>
                            </div>
                            @error('speed') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-item">
                        <div class="label">Deskripsi</div>
                        <div class="w-1/2">
                            <textarea wire:model="description" class="input w-full h-1/4"></textarea>
                            @error('description') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-item">
                        <div class="label">Tipe Paket</div>
                        <div class="w-1/2">
                            <select wire:model="type" class="input w-full">
                                <option value="">-- Pilih Tipe Paket --</option>
                                <option value="MONTHLY">Bulanan</option>
                                <option value="ANUALLY">Tahunan</option>
                            </select>
                            @error('type') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-item">
                        <div class="label"></div>
                        <x-button type="submit" className="btn btn-blue">
                            <div wire:loading wire:target="savePacket">
                                <x-loading-spinner className="h-3 w-3 mr-2" />
                            </div>
                            Simpan
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>