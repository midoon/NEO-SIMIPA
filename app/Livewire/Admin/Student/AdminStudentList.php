<?php

namespace App\Livewire\Admin\Student;

use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AdminStudentList extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Siswa')]

    public $search;

    #[Url()]
    public $grade_id;

    #[Url()]
    public $group_id;


    public $selected = [];
    public $selectAll = false;

    public function render()
    {
        try {
            $studentQuery = Student::query()
                ->leftJoin('groups', 'students.group_id', '=', 'groups.id')
                ->select('students.*', 'groups.name as group_name');

            if ($this->grade_id) {
                $studentQuery->where(function ($q) {
                    $q->whereHas('group.grade', function ($subQuery) {
                        $subQuery->where('id', $this->grade_id);
                    });
                });
            }
            if ($this->group_id) {
                $studentQuery->where('students.group_id', $this->group_id);
            }
            if ($this->search) {
                $studentQuery->where(function ($q) {
                    $q->where('students.name', 'like', '%' . $this->search . '%')
                        ->orWhere('students.nisn', 'like', '%' . $this->search . '%');
                });
            }

            $students = $studentQuery
                ->orderBy('groups.name')
                ->orderBy('students.name')
                ->paginate(20)
                ->withQueryString();
            return view('livewire.admin.student.admin-student-list', ['students' => $students]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem siswa load data: ' . $e->getMessage());
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
            $this->selected = Student::pluck('id')->toArray();
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
            return $this->redirect('/admin/group', navigate: true);
        }

        $this->dispatch('openModalDeleteMultipleEvent', selected: $this->selected);
    }
}
