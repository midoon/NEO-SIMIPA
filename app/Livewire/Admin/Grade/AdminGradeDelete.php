<?php

namespace App\Livewire\Admin\Grade;

use App\Models\Grade;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGradeDelete extends Component
{
    public $showModal = false;
    public $gradeId;

    public function render()
    {
        return view('livewire.admin.grade.admin-grade-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->gradeId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            Grade::findOrFail($this->gradeId)->delete();
            session()->flash('success', 'Data kelas berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/grade', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/grade', navigate: true);
        }
    }
}
