<?php

namespace App\Http\Livewire\Transaction;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    protected $listeners = ['updateStatus'];

    public function getTransactionProperty()
    {
        return Transaction::orderBy('created_at', 'DESC')->paginate();
    }

    public function render()
    {
        return view('livewire.transaction.show');
    }

    public function confirmStatus($trxId, $status)
    {
        $this->emit('confirmStatus', $trxId, $status);
    }

    public function updateStatus($trxId, $status)
    {
        $update = Transaction::where('id', $trxId)->update(['status' => $status]);
        if ($update)
            $this->resetPage();
    }
}
