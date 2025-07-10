<?php

namespace App\Livewire\Admin\Student;

use App\Models\Student;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminStudentDelete extends Component
{
    public $showModal = false;
    public $studentId;

    public function render()
    {
        return view('livewire.admin.student.admin-student-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->studentId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            Student::findOrFail($this->studentId)->delete();
            session()->flash('success', 'Data rombel berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/student', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/student', navigate: true);
        }
    }
}
