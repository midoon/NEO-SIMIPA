<?php

namespace App\Livewire\Admin\AssessmentType;

use App\Models\AssessmentType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class AdminAssessmentTypeList extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Tipe Penilaian')]

    public $search;

    public $selected = [];
    public $selectAll = false;

    public function render()
    {
        try {
            $assessmentTypeQuery = AssessmentType::query();
            if ($this->search) {
                $assessmentTypeQuery->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            }
            $assessmentTypes = $assessmentTypeQuery
                ->orderBy('name')
                ->paginate(20)
                ->withQueryString();
            return view('livewire.admin.assessment-type.admin-assessment-type-list', [
                'assessmentTypes' => $assessmentTypes,
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem kegiatan load data: ' . $e->getMessage());
            return $this->redirect('/admin/dashboard', navigate: true);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage(); // fungsi bawaan livewire
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

    public function updatedSelectAll($value)
    {

        if ($value) {
            // Select all student IDs
            $this->selected = AssessmentType::pluck('id')->toArray();
        } else {
            // Unselect all
            $this->selected = [];
        }
    }

    public function triggerModalDeleteMultiple()
    {
        if (count($this->selected) === 0) {
            session()->flash('error', 'Tidak ada data yang dipilih untuk dihapus.');
            return $this->redirect('/admin/assessment/type', navigate: true);
        }

        $this->dispatch('openModalDeleteMultipleEvent', selected: $this->selected);
    }
}
