<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherLogin extends Component
{
    #[Layout('components.layouts.auth')]
    #[Title('Teacher Login')]

    public $nik = "";
    public $password = "";
    public function render()
    {
        return view('livewire.auth.teacher-login');
    }

    public function login()
    {
        dd($this->nik);   // Handle login logic here
    }
}
