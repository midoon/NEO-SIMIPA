<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminTeacherDelete extends Component
{


    public $showModal = false;
    public $teacherId;

    public function render()
    {
        return view('livewire.admin.teacher.admin-teacher-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->teacherId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            Teacher::findOrFail($this->teacherId)->delete();
            session()->flash('success', 'Data guru berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/teacher', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem teacher delete: ' . $e->getMessage());
            return $this->redirect('/admin/teacher', navigate: true);
        }
    }
}
