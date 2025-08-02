<?php

namespace App\Livewire\Admin\Activity;

use App\Models\Activity;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminActivityEdit extends Component
{
    public $showModal = false;
    public $name;
    public $description;
    public $activityId;

    public function render()
    {
        return view('livewire.admin.activity.admin-activity-edit');
    }

    #[On('openModalEditEvent')]
    public function openModal($id)
    {
        $this->name = '';
        $this->description = '';
        $this->activityId = $id;
        $this->showModal = true;

        $subject = Activity::find($id);
        if ($subject) {
            $this->name = $subject->name;
            $this->description = $subject->description;
        } else {
            session()->flash('error', 'Kegiatan tidak ditemukan.');
            return $this->redirect('/admin/activity', navigate: true);
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
            ]);

            // Check if grade already exists

            $isExistActivity = Activity::where('name', $this->name)->first();
            if ($isExistActivity && $isExistActivity->id !== $this->activityId) {
                session()->flash('error', "Kode mata pelajaran sudah terdaftar.");
                return $this->redirect('/admin/activity', navigate: true);
            }
            if ($this->description === "") {
                $this->description = $this->name;
            }




            $activity = Activity::find($this->activityId);
            if ($activity) {
                $activity->update(['name' => $this->name, 'description' => $this->description]);
                session()->flash('success', 'Kegiatan berhasil diperbarui.');
            } else {
                session()->flash('error', 'Kegiatan tidak ditemukan.');
            }

            $this->showModal = false;
            $this->name = '';
            $this->activityId = null;
            $this->description = '';
            return $this->redirect('/admin/activity', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem update: ' . $e->getMessage());
            return $this->redirect('/admin/activity', navigate: true);
        }
    }
}
