<?php

namespace App\Livewire\Admin\Subject;

use App\Models\Subject;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AdminSubjectList extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Siswa')]

    public $search;

    public $selected = [];
    public $selectAll = false;
    public function render()
    {
        try {
            $subjectQuery = Subject::query();
            if ($this->search) {
                $subjectQuery->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            }
            $subjects = $subjectQuery->orderBy('name')->paginate(12)->withQueryString();
            return view('livewire.admin.subject.admin-subject-list', ['subjects' => $subjects]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem mata pelajaran load data: ' . $e->getMessage());
            return $this->redirect('/admin/dashboard', navigate: true);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage(); // fungsi bawaan livewire
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // Select all student IDs
            $this->selected = Subject::pluck('id')->toArray();
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
            return $this->redirect('/admin/student', navigate: true);
        }

        $this->dispatch('openModalDeleteMultipleEvent', selected: $this->selected);
    }
}
