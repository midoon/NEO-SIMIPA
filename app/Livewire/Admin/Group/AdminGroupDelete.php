<?php

namespace App\Livewire\Admin\Group;

use App\Models\Group;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGroupDelete extends Component
{
    public $showModal = false;
    public $groupId;

    public function render()
    {
        return view('livewire.admin.group.admin-group-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->groupId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            Group::findOrFail($this->groupId)->delete();
            session()->flash('success', 'Data rombel berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/group', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/group', navigate: true);
        }
    }
}
