<?php

namespace App\Http\Livewire\Ticket;

use App\Models\Conversation;
use App\Models\Ticket;
use Livewire\Component;

class Detail extends Component
{

    public $ticketId = null;
    public $conversations;
    public $ticket;

    public $body;

    protected $rules = [
        'body' => 'required',
    ];

    protected $messages = [
        'body.required' => 'Ketik sesuatu!'
    ];

    public function mount()
    {
        if ($this->ticketId != null) {
            $this->ticket = Ticket::where('id', $this->ticketId)->first();
            $this->conversations = $this->ticket->conversations;
        }
    }

    public function render()
    {
        return view('livewire.ticket.detail');
    }

    public function send()
    {
        $this->validate();
        Conversation::create([
            'ticket_id' => $this->ticketId,
            'body' => $this->body,
            'type' => 'FROM'
        ]);
        $this->redirect('#');
    }
}
