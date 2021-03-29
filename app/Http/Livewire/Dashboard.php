<?php

namespace App\Http\Livewire;

use App\Models\Packet;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalPacket;
    public $totalTrx;
    public $totalUser;
    public $totalTicket;

    public function mount()
    {
        $this->totalPacket = Packet::where('deleted_at', null)->count();
        $this->totalTrx = Transaction::count();
        $this->totalUser = User::where('role', 'USER')->count();
        $this->totalTicket = Ticket::count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
