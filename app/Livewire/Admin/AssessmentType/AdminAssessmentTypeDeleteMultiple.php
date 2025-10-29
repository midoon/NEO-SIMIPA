<?php

namespace App\Livewire\Admin\AssessmentType;

use App\Models\AssessmentType;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminAssessmentTypeDeleteMultiple extends Component
{
    public $showModal = false;
    public $selected = [];

    public function render()
    {
        return view('livewire.admin.assessment-type.admin-assessment-type-delete-multiple', ['selectedCount' => count($this->selected)]);
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
            AssessmentType::destroy($this->selected);
            $this->selected = [];
            session()->flash('success', 'Berhasil menghapus data tipe penilaian.');
            return $this->redirect('/admin/assessment/type', navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
            return $this->redirect('/admin/assessment/type', navigate: true);
        }
    }
}
