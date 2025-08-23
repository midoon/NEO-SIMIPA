<?php

namespace App\Livewire\Teacher\Attendance;

use App\Models\Activity;
use App\Models\Group;
use Livewire\Attributes\On;
use Livewire\Component;

class ReportFormFilter extends Component
{
    public $showModal = false;

    public $groupId, $activityId, $dateStart, $dateEnd = [];



    public function render()
    {
        $teacherId = session('teacher')['teacherId'];
        $groups =  Group::whereHas('schedules', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('name')->get();
        $activities = Activity::orderBy('name')->get();
        return view('livewire.teacher.attendance.report-form-filter', ['groups' => $groups, 'activities' => $activities]);
    }

    #[On('openFilterReport')]
    public function reportModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->groupId = '';
        $this->activityId = '';
        $this->dateStart = '';
        $this->dateEnd = '';
    }

    public function report()
    {
        // validasi
        $this->validate([
            'groupId'    => 'required|exists:groups,id',
            'activityId' => 'required|exists:activities,id',
            'dateStart'  => 'required|date',
            'dateEnd'    => 'required|date|after_or_equal:dateStart',
        ]);

        $params = [
            'groupId' => $this->groupId,
            'activityId' => $this->activityId,
            'dateStart' => $this->dateStart,
            'dateEnd' => $this->dateEnd,
        ];
        dd($params);

        return redirect()->to('/teacher/attendance/read?' . http_build_query($params));
    }
}
