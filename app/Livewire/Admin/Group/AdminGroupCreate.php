<?php

namespace App\Livewire\Admin\Group;

use App\Models\Grade;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGroupCreate extends Component
{
    public $showModal = false;
    public $name;
    public $grade_id = "";

    public function render()
    {
        try {
            $grades = Grade::orderBy('name')->get();
            return view('livewire.admin.group.admin-group-create', ['grades' => $grades]);
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memuat data: ' . $e->getMessage());
            return $this->redirect('/admin/group', navigate: true);
        }
    }

    #[On('openModalCreateEvent')]
    public function openModal()
    {
        $this->reset(['name', 'grade_id']);
        $this->showModal = true;
    }

    public function store()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'grade_id' => 'required|exists:grades,id',
            ]);

            // Check if group name already exists in the selected grade
            $isGroupExists = \App\Models\Group::where('name', $this->name)
                ->where('grade_id', $this->grade_id)
                ->exists();
            if ($isGroupExists) {
                session()->flash('error', 'Nama grup sudah terdaftar di kelas ini.');
                return $this->redirect('/admin/group', navigate: true);
            }

            \App\Models\Group::create([
                'name' => $this->name,
                'grade_id' => $this->grade_id,
            ]);

            session()->flash('success', 'Grup berhasil ditambahkan.');
            $this->showModal = false;
            return $this->redirect('/admin/group', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem groups store: ' . $e->getMessage());
            return $this->redirect('/admin/group', navigate: true);
        }
    }
}
