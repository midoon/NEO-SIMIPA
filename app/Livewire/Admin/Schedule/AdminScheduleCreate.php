<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\Group;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminScheduleCreate extends Component
{
    public $showModal = false;
    public $day, $groupId, $teacherId, $startTime, $endTime, $subjectId = [];

    protected $rules = [
        'day' => 'required|string|max:255',
        'groupId' => 'required|string',
        'teacherId' => 'required|string',
        'subjectId' => 'required|string',
        'startTime' => 'required|date_format:H:i',
        'endTime' => 'required|date_format:H:i|after:startTime',
    ];

    public function render()
    {
        $groups = Group::orderBy('name')->get();
        $teachers = Teacher::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        return view('livewire.admin.schedule.admin-schedule-create', [
            'groups' => $groups,
            'teachers' => $teachers,
            'subjects' => $subjects,
        ]);
    }

    #[On('openModalCreateEvent')]
    public function createModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->day = '';
        $this->groupId = '';
        $this->teacherId = '';
        $this->subjectId = '';
        $this->startTime = '';
        $this->endTime = '';
    }

    public function store()
    {
        try {
            $this->validate();

            Schedule::create([
                'day' => $this->day,
                'group_id' => $this->groupId,
                'teacher_id' => $this->teacherId,
                'subject_id' => $this->subjectId,
                'start_time' => $this->startTime,
                'end_time' => $this->endTime,
            ]);

            session()->flash('success', 'Jadwal berhasil ditambahkan.');
            $this->showModal = false;
            $this->resetInputFields();
            return $this->redirect('/admin/schedule', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem schedule store: ' . $e->getMessage());
            return $this->redirect('/admin/schedule', navigate: true);
        }
    }
}
