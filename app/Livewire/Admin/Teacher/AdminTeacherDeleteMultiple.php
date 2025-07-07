<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminTeacherDeleteMultiple extends Component
{
    public $showModal = false;
    public $selected = [];

    public function render()
    {
        return view('livewire.admin.teacher.admin-teacher-delete-multiple', [
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
            Teacher::destroy($this->selected);
            $this->selected = [];
            session()->flash('success', 'Berhasil menghapus data guru.');
            return $this->redirect('/admin/teacher', navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
