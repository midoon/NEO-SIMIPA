<?php

namespace App\Livewire\Teacher;

use App\Models\Schedule;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherDashboard extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Admin Dashboard')]

    public function render()
    {
        $teacherId = session('teacher')['teacherId'];
        $today = Carbon::now()->isoFormat('dddd');
        $schedules = Schedule::where('day', strtolower($today))->when($teacherId, function ($query, $teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('start_time', 'asc')->get();
        return view('livewire.teacher.teacher-dashboard', ['schedules' => $schedules]);
    }
}
