<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherRegister extends Component
{
    #[Layout('components.layouts.auth')]
    #[Title('Teacher Register')]

    public $nik = "";
    public $password = "";
    public $confirm_password = "";
    public function render()
    {
        return view('livewire.auth.teacher-register');
    }

    public function register()
    {
        dd("register");
    }
}
