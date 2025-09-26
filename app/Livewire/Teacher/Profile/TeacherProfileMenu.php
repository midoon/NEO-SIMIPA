<?php

namespace App\Livewire\Teacher\Profile;

use App\Models\Teacher;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherProfileMenu extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Payment')]

    public $name, $nik, $gender;

    public function mount()
    {
        $teacherId = session('teacher')['teacherId'];
        $teacher = Teacher::find($teacherId);

        $this->name = $teacher->name;
        $this->nik = $teacher->nik;
        $this->gender = $teacher->gender;
    }

    public function render()
    {
        return view('livewire.teacher.profile.teacher-profile-menu');
    }

    public function updateProfile()
    {
        dd($this->name, $this->nik, $this->gender);
    }
}
