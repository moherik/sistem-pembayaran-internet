<?php

namespace App\Http\Livewire\Packet;

use App\Models\Packet;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $listeners = ['deletePacket'];

    public function getPacketProperty()
    {
        return Packet::where('deleted_at', null)->orderBy('created_at', 'DESC')->paginate(10);
    }

    public function render()
    {
        return view('livewire.packet.show')->layout('layouts.app');
    }

    public function confirmDelete($packetId)
    {
        $this->emit('confirmDeletePacket', $packetId);
    }

    public function deletePacket($packetId)
    {
        $packet = Packet::where('id', $packetId)->update(['deleted_at' => now()]);
        if ($packet) {
            $this->resetPage();
        }
    }
}
