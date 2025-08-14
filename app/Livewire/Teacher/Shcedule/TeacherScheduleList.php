<?php

namespace App\Livewire\Teacher\Shcedule;

use App\Models\Schedule;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Str;

class TeacherScheduleList extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Dashboard')]

    public $selectedDay;

    public function mount()
    {
        Carbon::setLocale('id'); // set locale ke bahasa Indonesia
        $this->selectedDay = strtolower(now()->translatedFormat('l'));
    }

    public function selectDay($day)
    {
        $this->selectedDay = $day;
    }

    public function render()
    {


        try {
            $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
            $teacherId = session('teacher')['teacherId'];
            $schedules = Schedule::where('day', strtolower($this->selectedDay))->when($teacherId, function ($query, $teacherId) {
                $query->where('teacher_id', $teacherId);
            })->orderBy('start_time', 'asc')->get();
            return view('livewire.teacher.shcedule.teacher-schedule-list', [
                'schedules' => $schedules,
                'days' => $days,

            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while fetching the schedule.');
            return $this->redirect('/teacher/dashboard', navigate: true);
        }
    }
}
