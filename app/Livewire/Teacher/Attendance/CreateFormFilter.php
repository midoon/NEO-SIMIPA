<?php

namespace App\Livewire\Teacher\Attendance;

use App\Models\Activity;
use App\Models\Group;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateFormFilter extends Component
{
    public $showModal = false;

    public $groupId, $activityId, $date = [];

    public function mount()
    {
        $this->date = Carbon::now()->format('Y-m-d'); // contoh: 17-08-2025
    }

    public function render()
    {
        $teacherId = session('teacher')['teacherId'];
        $groups =  Group::whereHas('schedules', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('name')->get();
        $activities = Activity::orderBy('name')->get();
        return view('livewire.teacher.attendance.create-form-filter', ['groups' => $groups, 'activities' => $activities]);
    }

    #[On('openFilterCreate')]
    public function createModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->groupId = '';
        $this->activityId = '';
        $this->date = '';
    }

    public function create()
    {
        dd($this->date);
    }
}
