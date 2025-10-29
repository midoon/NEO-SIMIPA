<?php

namespace App\Livewire\Admin\AssessmentType;

use App\Models\AssessmentType;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminAssessmentTypeCreate extends Component
{
    public $showModal = false;
    public $name, $code = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('livewire.admin.assessment-type.admin-assessment-type-create');
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
            if (AssessmentType::where('name', $this->name)->exists() || AssessmentType::where('code', $this->code)->exists()) {
                session()->flash('error', 'Tipe penilaian sudah terdaftar.');
                return $this->redirect('/admin/assessment/type', navigate: true);
            }



            AssessmentType::create([
                'name' => $this->name,
                'code' => $this->code,
            ]);

            session()->flash('success', 'Tipe penilaian berhasil ditambahkan.');
            $this->showModal = false;
            $this->resetInputFields();
            return $this->redirect('/admin/assessment/type', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem assessment type store: ' . $e->getMessage());
            return $this->redirect('/admin/assessment/type', navigate: true);
        }
    }
}
