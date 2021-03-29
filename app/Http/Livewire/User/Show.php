<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public function getUserProperty()
    {
        return User::where('role', 'USER')->orderBy('id', 'ASC')->paginate(10);
    }

    public function render()
    {
        return view('livewire.user.show');
    }
}
