<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\Schedule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AdminScheduleList extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Jadwal')]

    public $search;

    #[Url()] // mengambil nilai dari query param dan ditaruh langsung ke $grade_id
    public $subject_id;

    public $selected = [];
    public $selectAll = false;

    public function render()
    {
        try {
            $scheduleQuery = Schedule::query()
                ->leftJoin('subjects', 'schedules.subject_id', '=', 'subjects.id')
                ->leftJoin('teachers', 'schedules.teacher_id', '=', 'teachers.id')
                ->leftJoin('groups', 'schedules.group_id', "=", 'groups.id')
                ->select('schedules.*', 'subjects.name as subject_name', 'teachers.name as teacher_name', 'groups.name as group_name');

            if ($this->subject_id) {
                $scheduleQuery->where('schedules.subject_id', $this->subject_id);
            }

            if ($this->search) {
                $scheduleQuery->where(function ($q) {
                    $q->where('schedules.day_of_week', 'like', '%' . $this->search . '%')
                        ->orWhere('subjects.name', 'like', '%' . $this->search . '%')
                        ->orWhere('teachers.name', 'like', '%' . $this->search . '%')
                        ->orWhere('groups.name', 'like', '%', $this->search . '%');
                });
            }

            $schedules = $scheduleQuery
                ->orderByRaw("FIELD(day_of_week, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
                ->orderBy('groups.name')
                ->orderBy('start_time')
                ->paginate(20)
                ->withQueryString();


            return view('livewire.admin.schedule.admin-schedule-list', ['schedules' => $schedules]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem schedule load data: ' . $e->getMessage());
            return $this->redirect('/admin/dashboard', navigate: true);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
        $this->reset('grade_id');
        $this->reset('group_id');
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // Select all student IDs
            $this->selected = Schedule::pluck('id')->toArray();
        } else {
            // Unselect all
            $this->selected = [];
        }
    }

    public function triggerModalCreate()
    {
        $this->dispatch('openModalCreateEvent');
    }

    public function triggerModalEdit($id)
    {
        $this->dispatch('openModalEditEvent', id: $id);
    }

    public function triggerModalDelete($id)
    {
        $this->dispatch('openModalDeleteEvent', id: $id);
    }

    public function triggerModalUpload()
    {
        $this->dispatch('openModalUploadEvent');
    }

    public function triggerModalDeleteMultiple()
    {
        if (count($this->selected) === 0) {
            session()->flash('error', 'Tidak ada data yang dipilih untuk dihapus.');
            return $this->redirect('/admin/schedule', navigate: true);
        }

        $this->dispatch('openModalDeleteMultipleEvent', selected: $this->selected);
    }
}
