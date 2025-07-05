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
        $teacher = Teacher::findOrFail($id);
        $this->teacherId = $teacher->id;
        $this->name = $teacher->name;
        $this->nik = $teacher->nik;
        $this->gender = $teacher->gender;
        $this->roles = $teacher->role;

        $this->showModalEdit = true;
    }

    public function update()
    {
        $this->validate();

        $teacher = Teacher::findOrFail($this->teacherId);
        $teacher->update([
            'name' => $this->name,
            'nik' => $this->nik,
            'gender' => $this->gender,
            'role' => $this->roles,
        ]);

        session()->flash('message', 'Data guru berhasil diupdate.');
        $this->showModalEdit = false;
        $this->emit('teacherUpdated'); // untuk refresh list di komponen parent jika diperlukan
    }
}
