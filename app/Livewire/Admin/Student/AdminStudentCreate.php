<?php

namespace App\Livewire\Admin\Student;

use App\Events\StudentAssignedToGroup;
use App\Models\Group;
use App\Models\Student;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminStudentCreate extends Component
{
    public $showModal = false;
    public $name, $nisn, $gender, $groupId = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'nisn' => 'required|string|max:50',
        'gender' => 'required|string',
        'groupId' => 'required',
    ];

    public function render()
    {
        $groups = Group::orderBy('name')->get();
        return view('livewire.admin.student.admin-student-create', ['groups' => $groups]);
    }

    #[On('openModalCreateEvent')]
    public function createModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->nisn = '';
        $this->gender = '';
        $this->groupId = [];
    }

    public function store()
    {
        try {
            $this->validate();

            // Check if NIK already exists
            if (Student::where('nisn', $this->nisn)->exists()) {
                session()->flash('error', 'NISN sudah terdaftar.');
                return $this->redirect('/admin/student', navigate: true);
            }

            $studnet = Student::create([
                'name' => $this->name,
                'nisn' => $this->nisn,
                'gender' => $this->gender,
                'group_id' => $this->groupId,
            ]);

            StudentAssignedToGroup::dispatch($studnet);

            session()->flash('success', 'Siswa berhasil ditambahkan.');
            $this->showModal = false;
            $this->resetInputFields();
            return $this->redirect('/admin/student', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem student store: ' . $e->getMessage());
            return $this->redirect('/admin/student', navigate: true);
        }
    }
}
