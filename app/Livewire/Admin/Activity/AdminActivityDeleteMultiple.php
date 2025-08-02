<?php

namespace App\Livewire\Admin\Activity;

use App\Models\Activity;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminActivityDeleteMultiple extends Component
{
    public $showModal = false;
    public $selected = [];

    public function render()
    {
        return view('livewire.admin.activity.admin-activity-delete-multiple', ['selectedCount' => count($this->selected)]);
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
            Activity::destroy($this->selected);
            $this->selected = [];
            session()->flash('success', 'Berhasil menghapus data kegiatan.');
            return $this->redirect('/admin/activity', navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
            return $this->redirect('/admin/activity', navigate: true);
        }
    }
}
