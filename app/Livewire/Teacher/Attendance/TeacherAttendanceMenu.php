<?php

namespace App\Livewire\Teacher\Attendance;

use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherAttendanceMenu extends Component
{

    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Attendance')]

    public $todayDate;
    public $todayDay;

    public function mount()
    {
        $this->todayDate = Carbon::now()->format('d-m-Y'); // contoh: 17-08-2025
        $this->todayDay  = Carbon::now()->translatedFormat('l'); // contoh: Minggu
    }

    public function render()
    {
        return view('livewire.teacher.attendance.teacher-attendance-menu');
    }

    public function triggerFilterCreate()
    {
        $this->dispatch('openFilterCreate');
    }
}
