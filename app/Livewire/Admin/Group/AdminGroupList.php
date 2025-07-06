<?php

namespace App\Livewire\Admin\Group;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class AdminGroupList extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Rombel')]

    public $search;
    public function render()
    {
        try {
            $groupQuery = \App\Models\Group::query();
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
}
