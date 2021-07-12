<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $label }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dasbor</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('packet.show') }}">Daftar Paket</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if($alertText != "")
            <div class="mb-4">
                <x-alert type="{{ $alertType }}">{{ $alertText }}</x-alert>
            </div>
            @endif

            <div class="card p-3">
                <form class="form" wire:submit.prevent="savePacket">
                    <div class="form-group">
                        <label>Nama</label>
                        <div>
                            <input type="text" wire:model="name" placeholder="Nama Paket" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" />
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label>Kecepatan</label>
                        <div class="w-1/2">
                            <div class="d-flex">
                                <input type="text" wire:model="speed" placeholder="100" class="form-control" />
                                <span class="ml-2 text-gray-800">Mbps</span>
                            </div>
                            @error('speed') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <div>
                            <textarea wire:model="description" class="form-control"></textarea>
                            @error('description') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tipe Paket</label>
                        <div>
                            <select wire:model="type" class="form-control">
                                <option value="">-- Pilih Tipe Paket --</option>
                                <option value="MONTHLY">Bulanan</option>
                                <option value="ANUALLY">Tahunan</option>
                            </select>
                            @error('type') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <div>
                            <input type="text" wire:model="price" placeholder="Harga Paket" class="form-control" />
                            @error('price') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <x-button type="submit" className="btn btn-primary">
                        <div wire:loading wire:target="savePacket">
                            <x-loading-spinner className="h-3 w-3 mr-2" />
                        </div>
                        Simpan
                    </x-button>
                </form>
            </div>
        </div>
    </div>

</div>