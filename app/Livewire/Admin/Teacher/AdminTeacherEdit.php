<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminTeacherEdit extends Component
{


    public $showModalEdit = false;
    public $teacherId, $name, $nik, $gender, $roles = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'nik' => 'required|string|max:50',
        'gender' => 'required|string',
        'roles' => 'required|array',
    ];


    public function render()
    {
        return view('livewire.admin.teacher.admin-teacher-edit');
    }


    #[On('openModalEditEvent')]
    public function openModalEdit($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);
            $this->teacherId = $teacher->id;
            $this->name = $teacher->name;
            $this->nik = $teacher->nik;
            $this->gender = $teacher->gender;
            $this->roles = $teacher->role;

            $this->showModalEdit = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal update data: ' . $e->getMessage());
            return $this->redirect('/admin/teacher', navigate: true);
        }
    }

    public function update()
    {
        try {
            $this->validate();

            // Check if NIK already exists
            if (Teacher::where('nik', $this->nik)->exists() && Teacher::where('nik', $this->nik)->first()->id !== $this->teacherId) {
                session()->flash('error', 'NIK sudah terdaftar.');
                return $this->redirect('/admin/teacher', navigate: true);
            }

            $teacher = Teacher::findOrFail($this->teacherId);
            $teacher->update([
                'name' => $this->name,
                'nik' => $this->nik,
                'gender' => $this->gender,
                'role' => $this->roles,
            ]);

            session()->flash('success', 'Data guru berhasil diupdate.');
            $this->showModalEdit = false;
            return $this->redirect('/admin/teacher', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal update data: ' . $e->getMessage());
            return $this->redirect('/admin/teacher', navigate: true);
        }
    }
}
