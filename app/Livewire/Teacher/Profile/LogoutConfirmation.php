<?php

namespace App\Livewire\Teacher\Profile;

use Livewire\Attributes\On;
use Livewire\Component;

class LogoutConfirmation extends Component
{
    public $showModal = false;

    public function render()
    {
        return view('livewire.teacher.profile.logout-confirmation');
    }

    #[On('logoutConfirmation')]
    public function openModal()
    {

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function logout()
    {
        // clear session
        session()->forget('teacher');
        // redirect to login page
        session()->flash('success', 'Berhasil logout');
        return $this->redirect('/teacher/login', navigate: true);
    }
}
