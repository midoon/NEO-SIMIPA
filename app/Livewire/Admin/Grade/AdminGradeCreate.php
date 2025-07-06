<?php

namespace App\Livewire\Admin\Grade;

use App\Models\Grade;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGradeCreate extends Component
{
    public $showModal = false;
    public $name;
    public function render()
    {
        return view('livewire.admin.grade.admin-grade-create');
    }

    #[On('openModalCreateEvent')]
    public function openModal()
    {
        $this->name = '';
        $this->showModal = true;
    }

    public function store()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
            ]);

            // Check if grade already exists
            if (Grade::where('name', $this->name)->exists()) {
                session()->flash('error', "Kelas  sudah terdaftar.");
                return $this->redirect('/admin/grade', navigate: true);
            }

            Grade::create(['name' => $this->name]);

            session()->flash('success', 'Kelas berhasil ditambahkan.');
            $this->showModal = false;
            $this->name = '';
            return $this->redirect('/admin/grade', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem store: ' . $e->getMessage());
            return $this->redirect('/admin/grade', navigate: true);
        }
    }
}
