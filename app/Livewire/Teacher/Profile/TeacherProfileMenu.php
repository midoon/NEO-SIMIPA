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

    protected $listeners = ['refreshParent' => '$refresh'];

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

    public function edit()
    {
        $this->dispatch('updateConfirmation', name: $this->name, nik: $this->nik, gender: $this->gender);
    }
}
