<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminTeacherCreate extends Component
{
    public $showModal = false;
    public $name, $nik, $gender, $roles = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'nik' => 'required|string|max:50',
        'gender' => 'required|string',
        'roles' => 'required|array',
    ];

    public function render()
    {
        return view('livewire.admin.teacher.admin-teacher-create');
    }

    #[On('openModalCreateEvent')]
    public function createModalTeacher()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    public function store()
    {
        try {
            $this->validate();

            Teacher::create([
                'name' => $this->name,
                'nik' => $this->nik,
                'gender' => $this->gender,
                'role' => $this->roles,
            ]);

            session()->flash('message', 'Guru berhasil ditambahkan.');
            $this->showModal = false;
            $this->resetInputFields();
            return $this->redirect('/admin/teacher', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
            return $this->redirect('/admin/teacher', navigate: true);
        }
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->nik = '';
        $this->gender = '';
        $this->roles = [];
    }
}
