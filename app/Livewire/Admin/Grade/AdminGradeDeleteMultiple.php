<?php

namespace App\Livewire\Admin\Grade;

use App\Models\Grade;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGradeDeleteMultiple extends Component
{
    public $showModal = false;
    public $selected = [];

    public function render()
    {
        return view('livewire.admin.grade.admin-grade-delete-multiple', [
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
            Grade::destroy($this->selected);
            $this->selected = [];
            session()->flash('success', 'Berhasil menghapus data kelas.');
            return $this->redirect('/admin/grade', navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
            return $this->redirect('/admin/grade', navigate: true);
        }
    }
}
