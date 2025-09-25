<?php

namespace App\Livewire\Teacher\Profile;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherProfileMenu extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Payment')]

    public function render()
    {
        return view('livewire.teacher.profile.teacher-profile-menu');
    }
}
