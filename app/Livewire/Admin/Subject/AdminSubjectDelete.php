<?php

namespace App\Livewire\Admin\Subject;

use App\Models\Subject;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminSubjectDelete extends Component
{
    public $showModal = false;
    public $subjectId;

    public function render()
    {
        return view('livewire.admin.subject.admin-subject-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->subjectId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            Subject::findOrFail($this->subjectId)->delete();
            session()->flash('success', 'Data mata pelajaran berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/subject', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/subject', navigate: true);
        }
    }
}
