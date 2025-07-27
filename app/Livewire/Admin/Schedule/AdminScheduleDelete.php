<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\Schedule;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminScheduleDelete extends Component
{
    public $showModal = false;
    public $scheduleId;

    public function render()
    {
        return view('livewire.admin.schedule.admin-schedule-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->scheduleId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            Schedule::findOrFail($this->scheduleId)->delete();
            session()->flash('success', 'Data jadwal berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/schedule', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/schedule', navigate: true);
        }
    }
}
