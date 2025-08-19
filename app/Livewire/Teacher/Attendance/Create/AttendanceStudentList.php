<?php

namespace App\Livewire\Teacher\Attendance\Create;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AttendanceStudentList extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Attendance')]

    public function render()
    {
        return view('livewire.teacher.attendance.create.attendance-student-list');
    }
}
