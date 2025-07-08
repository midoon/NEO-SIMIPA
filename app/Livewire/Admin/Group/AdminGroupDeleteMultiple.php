<?php

namespace App\Livewire\Admin\Group;

use App\Models\Group;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGroupDeleteMultiple extends Component
{
    public $showModal = false;
    public $selected = [];

    public function render()
    {
        return view('livewire.admin.group.admin-group-delete-multiple', [
            'selectedCount' => count($this->selected),
        ]);
    }

    #[On('openModalDeleteMultipleEvent')]
    public function openModal($selected)
    {
        $this->selected = $selected;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selected = [];
    }

    public function deleteSelected()
    {
        try {
            Group::destroy($this->selected);
            $this->selected = [];
            session()->flash('success', 'Berhasil menghapus data rombel.');
            return $this->redirect('/admin/group', navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
            return $this->redirect('/admin/group', navigate: true);
        }
    }
}
