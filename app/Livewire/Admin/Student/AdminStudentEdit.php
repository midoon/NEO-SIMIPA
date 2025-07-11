<?php

namespace App\Livewire\Admin\Student;

use App\Models\Group;
use App\Models\Student;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminStudentEdit extends Component
{
    public $showModal = false;
    public $name, $nisn, $gender, $groupId, $studentId = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'nisn' => 'required|string|max:50',
        'gender' => 'required|string',
        'groupId' => 'required',
    ];

    public function render()
    {
        $groups = Group::orderBy('name')->get();
        return view('livewire.admin.student.admin-student-edit', ['groups' => $groups]);
    }

    #[On('openModalEditEvent')]
    public function openModal($id)
    {

        $this->studentId = $id;
        $this->showModal = true;

        // Load the grade data by ID
        $student = Student::find($id);
        if ($student) {
            $this->name = $student->name;
            $this->nisn = $student->nisn;
            $this->gender = $student->gender;
            $this->groupId = $student->group_id;
        } else {
            session()->flash('error', 'Siswa tidak ditemukan.');
            return $this->redirect('/admin/student', navigate: true);
        }
    }

    public function update()
    {
        try {
            $this->validate();

            // Check if group already exists

            if (Student::where('nisn', $this->nisn)->exists() && Student::where('nisn', $this->nisn)->first()->id !== $this->studentId) {

                session()->flash('error', "Siswa sudah terdaftar.");
                return $this->redirect('/admin/student', navigate: true);
            }

            $student = Student::find($this->studentId);
            if ($student) {
                $student->update([
                    'name' => $this->name,
                    'group_id' => $this->groupId,
                    'nisn' => $this->nisn,
                    'gender' => $this->gender
                ]);
                session()->flash('success', 'Siswa berhasil diperbarui.');
            } else {
                session()->flash('error', 'Siswa tidak ditemukan.');
            }

            $this->showModal = false;
            $this->resetInput();
            $this->groupId = null;
            return $this->redirect('/admin/student', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem update: ' . $e->getMessage());
            return $this->redirect('/admin/student', navigate: true);
        }
    }

    public function resetInput()
    {
        $this->name = "";
        $this->nisn = "";
        $this->gender = "";
        $this->groupId = "";
    }
}
