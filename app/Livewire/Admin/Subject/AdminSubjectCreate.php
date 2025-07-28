<?php

namespace App\Livewire\Admin\Subject;

use App\Models\Subject;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminSubjectCreate extends Component
{
    public $showModal = false;
    public $name, $code = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:255',
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
        $this->code = '';
    }

    public function store()
    {
        try {
            $this->validate();

            // Check if subject already exists
            if (Subject::where('name', $this->name)->exists() || Subject::where('code', $this->code)->exists()) {
                session()->flash('error', 'Mata pelajaran sudah terdaftar.');
                return $this->redirect('/admin/subject', navigate: true);
            }



            Subject::create([
                'name' => $this->name,
                'code' => $this->code,
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
