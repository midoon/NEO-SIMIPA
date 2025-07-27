<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\Schedule;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminScheduleDeleteMultiple extends Component
{
    public $showModal = false;
    public $selected = [];

    public function render()
    {
        return view('livewire.admin.schedule.admin-schedule-delete-multiple', [
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
            Schedule::destroy($this->selected);
            $this->selected = [];
            session()->flash('success', 'Berhasil menghapus data jadwal.');
            return $this->redirect('/admin/schedule', navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
            return $this->redirect('/admin/schedule', navigate: true);
        }
    }
}
