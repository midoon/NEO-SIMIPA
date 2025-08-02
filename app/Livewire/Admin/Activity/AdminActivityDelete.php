<?php

namespace App\Livewire\Admin\Activity;

use App\Models\Activity;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminActivityDelete extends Component
{
    public $showModal = false;
    public $activityId;

    public function render()
    {
        return view('livewire.admin.activity.admin-activity-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->activityId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            Activity::findOrFail($this->activityId)->delete();
            session()->flash('success', 'Data kegiatan berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/activity', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/activity', navigate: true);
        }
    }
}
