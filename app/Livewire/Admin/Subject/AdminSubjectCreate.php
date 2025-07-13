<?php

namespace App\Livewire\Admin\Subject;

use App\Models\Subject;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminSubjectCreate extends Component
{
    public $showModal = false;
    public $name, $description = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'string|max:255',
    ];

    public function render()
    {
        return view('livewire.admin.subject.admin-subject-create');
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
        $this->description = '';
    }

    public function store()
    {
        try {
            $this->validate();

            // Check if NIK already exists
            if (Subject::where('name', $this->name)->exists()) {
                session()->flash('error', 'Mata pelajaran sudah terdaftar.');
                return $this->redirect('/admin/subject', navigate: true);
            }

            if ($this->description == "") {
                $this->description = $this->name;
            }

            Subject::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            session()->flash('success', 'Siswa berhasil ditambahkan.');
            $this->showModal = false;
            $this->resetInputFields();
            return $this->redirect('/admin/subject', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem subject store: ' . $e->getMessage());
            return $this->redirect('/admin/subject', navigate: true);
        }
    }
}
