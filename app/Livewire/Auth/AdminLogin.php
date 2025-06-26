<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AdminLogin extends Component
{
    #[Layout('components.layouts.auth')]
    #[Title('Admin Login')]

    public $username = "";
    public $password = "";

    public function render()
    {
        return view('livewire.auth.admin-login');
    }

    public function login()
    {
        dd($this->username);   // Handle login logic here
    }
}
