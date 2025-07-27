<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\Group;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminScheduleEdit extends Component
{
    public $showModal = false;
    public $day, $groupId, $teacherId, $startTime, $endTime, $subjectId, $scheduleId = [];

    protected $rules = [
        'day' => 'required|string|max:255',
        'groupId' => 'required',
        'teacherId' => 'required',
        'subjectId' => 'required',
        'startTime' => 'required|date_format:H:i',
        'endTime' => 'required|date_format:H:i|after:startTime',
    ];

    public function render()
    {
        $groups = Group::orderBy('name')->get();
        $teachers = Teacher::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        return view('livewire.admin.schedule.admin-schedule-edit', [
            'groups' => $groups,
            'teachers' => $teachers,
            'subjects' => $subjects,
        ]);
    }

    #[On('openModalEditEvent')]
    public function openModal($id)
    {

        $this->scheduleId = $id;
        $this->showModal = true;

        // Load the grade data by ID
        $schedule = Schedule::find($id);
        if ($schedule) {
            $this->day = $schedule->day;
            $this->groupId = $schedule->group_id;
            $this->teacherId = $schedule->teacher_id;
            $this->subjectId = $schedule->subject_id;
            $this->startTime = $schedule->start_time;
            $this->endTime = $schedule->end_time;
        } else {
            session()->flash('error', 'Jadwal tidak ditemukan.');
            return $this->redirect('/admin/schedule', navigate: true);
        }
    }

    public function update()
    {
        try {
            $this->validate();



            $schedule = Schedule::find($this->scheduleId);
            if ($schedule) {
                $schedule->update([
                    'day' => $this->day,
                    'group_id' => $this->groupId,
                    'teacher_id' => $this->teacherId,
                    'subject_id' => $this->subjectId,
                    'start_time' => $this->startTime,
                    'end_time' => $this->endTime,
                ]);
                session()->flash('success', 'Jadwal berhasil diperbarui.');
            } else {
                session()->flash('error', 'Jadwal tidak ditemukan.');
            }

            $this->showModal = false;
            $this->resetInputFields();
            $this->scheduleId = null;
            return $this->redirect('/admin/schedule', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem update: ' . $e->getMessage());
            return $this->redirect('/admin/schedule', navigate: true);
        }
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
}
