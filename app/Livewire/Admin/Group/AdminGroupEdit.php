<?php

namespace App\Livewire\Admin\Group;

use App\Models\Grade;
use App\Models\Group;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGroupEdit extends Component
{
    public $showModal = false;
    public $name;
    public $groupId;
    public $gradeId;

    public function render()
    {
        $grades = Grade::orderBy('name')->get();
        return view('livewire.admin.group.admin-group-edit', ['grades' => $grades]);
    }

    #[On('openModalEditEvent')]
    public function openModal($id)
    {
        $this->name = '';
        $this->groupId = $id;
        $this->showModal = true;

        // Load the grade data by ID
        $group = Group::find($id);
        if ($group) {
            $this->name = $group->name;
            $this->gradeId = $group->grade_id;
        } else {
            session()->flash('error', 'Rombel tidak ditemukan.');
            return $this->redirect('/admin/group', navigate: true);
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'gradeId' => 'required',
            ]);

            // Check if group already exists
            if (Group::where('name', $this->name)->where('grade_id', $this->gradeId)->exists()) {
                session()->flash('error', "Rombel sudah terdaftar.");
                return $this->redirect('/admin/group', navigate: true);
            }

            // Update the group
            $group = Group::find($this->groupId);
            if ($group) {
                $group->update([
                    'name' => $this->name,
                    'grade_id' => $this->gradeId,
                ]);
                session()->flash('success', 'Kelas berhasil diperbarui.');
            } else {
                session()->flash('error', 'Kelas tidak ditemukan.');
            }

            $this->showModal = false;
            $this->name = '';
            $this->groupId = null;
            return $this->redirect('/admin/group', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem update: ' . $e->getMessage());
            return $this->redirect('/admin/group', navigate: true);
        }
    }
}
