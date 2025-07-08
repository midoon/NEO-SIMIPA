<?php

namespace App\Livewire\Admin\Group;

use App\Models\Group;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AdminGroupList extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Rombel')]

    #[Url()]
    public $grade_id;

    public $selected = [];
    public $selectAll = false;

    public $search;
    public function render()
    {
        try {
            $groupQuery = Group::query();
            if ($this->grade_id) {
                $groupQuery->where('grade_id', $this->grade_id);
            }
            if ($this->search) {
                $groupQuery->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            }
            $groups = $groupQuery->orderBy('name')->paginate(12)->withQueryString();
            return view('livewire.admin.group.admin-group-list', ['groups' => $groups]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem group load data: ' . $e->getMessage());
            return $this->redirect('/admin/group', navigate: true);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
        $this->reset('grade_id');
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // Select all student IDs
            $this->selected = Group::pluck('id')->toArray();
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
