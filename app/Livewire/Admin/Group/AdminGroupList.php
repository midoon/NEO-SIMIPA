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
}
