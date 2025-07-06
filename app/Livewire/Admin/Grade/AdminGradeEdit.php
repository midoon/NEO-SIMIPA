<?php

namespace App\Livewire\Admin\Grade;

use App\Models\Grade;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGradeEdit extends Component
{
    public $showModal = false;
    public $name;
    public $gradeId;

    public function render()
    {
        return view('livewire.admin.grade.admin-grade-edit');
    }

    #[On('openModalEditEvent')]
    public function openModal($id)
    {
        $this->name = '';
        $this->gradeId = $id;
        $this->showModal = true;

        // Load the grade data by ID
        $grade = Grade::find($id);
        if ($grade) {
            $this->name = $grade->name;
        } else {
            session()->flash('error', 'Kelas tidak ditemukan.');
            return $this->redirect('/admin/grade', navigate: true);
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
            ]);

            // Check if grade already exists
            if (Grade::where('name', $this->name)->exists()) {
                session()->flash('error', "Kelas sudah terdaftar.");
                return $this->redirect('/admin/grade', navigate: true);
            }

            // Update the grade
            $grade = Grade::find($this->gradeId);
            if ($grade) {
                $grade->update(['name' => $this->name]);
                session()->flash('success', 'Kelas berhasil diperbarui.');
            } else {
                session()->flash('error', 'Kelas tidak ditemukan.');
            }

            $this->showModal = false;
            $this->name = '';
            $this->gradeId = null;
            return $this->redirect('/admin/grade', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem update: ' . $e->getMessage());
            return $this->redirect('/admin/grade', navigate: true);
        }
    }
}
