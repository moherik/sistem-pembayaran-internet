<?php

namespace App\Http\Livewire\Ticket;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $listeners = ['deleteTicket'];

    public function getTicketProperty()
    {
        return Ticket::orderBy('created_at', 'DESC')->paginate(10);
    }

    public function render()
    {
        return view('livewire.ticket.show');
    }

    public function confirmDelete($ticketId)
    {
        $this->emit('confirmDeleteTicket', $ticketId);
    }

    public function deleteTicket($ticketId)
    {
        $ticket = Ticket::where('id', $ticketId)->first();
        if ($ticket) {
            $ticket->delete();
            $this->resetPage();
        }
    }
}
