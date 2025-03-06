<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Users extends Component
{
    public function render()
    {
        $users = User::whereNot('id', Auth::id())->get();
        return view('livewire.users', [
            'users' => $users
        ])->layout('layouts.app');
    }
}
