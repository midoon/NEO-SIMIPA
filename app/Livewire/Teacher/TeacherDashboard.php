<?php

namespace App\Livewire\Teacher;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherDashboard extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Dashboard')]

    public $selectedDay;

    public function mount()
    {
        Carbon::setLocale('id'); // set locale ke bahasa Indonesia
        $this->selectedDay = strtolower(now()->translatedFormat('l'));
    }

    public function changeDay($day)
    {
        $this->selectedDay = strtolower($day);
    }

    public function render()
    {
        $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
        $teacherId = session('teacher')['teacherId'];
        $teacher = DB::table('teachers')->select('name')->where('id', $teacherId)->first();

        $schedules = Schedule::where('day', $this->selectedDay)->when($teacherId, function ($query, $teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('start_time', 'asc')->get();
        return view('livewire.teacher.teacher-dashboard', ['schedules' => $schedules, 'days' => $days, 'teacher' => $teacher]);
    }
}
