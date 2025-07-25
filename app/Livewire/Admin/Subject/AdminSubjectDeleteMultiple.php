<?php

namespace App\Livewire\Admin\Subject;

use App\Models\Subject;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminSubjectDeleteMultiple extends Component
{
    public $showModal = false;
    public $selected = [];

    public function render()
    {
        return view('livewire.admin.subject.admin-subject-delete-multiple', [
            'selectedCount' => count($this->selected)
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
            Subject::destroy($this->selected);
            $this->selected = [];
            session()->flash('success', 'Berhasil menghapus data mata pelajaran.');
            return $this->redirect('/admin/subject', navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
            return $this->redirect('/admin/subject', navigate: true);
        }
    }
}
