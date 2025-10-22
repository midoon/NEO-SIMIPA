<?php

namespace App\Livewire\Admin\Activity;

use App\Models\Activity;
use Illuminate\Support\Facades\DB;
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
            $existData = [];
            if (DB::table('attendances')->where('activity_id', $this->activityId)->exists()) {
                array_push($existData, 'presensi');
            }



            if (count($existData) != 0) {
                $this->dispatch('confirmDelete', [
                    'message' => "Data siswa yang ingin anda hapus masih digunakan di data " . implode(", ", $existData)
                ]);
                return;
            }

            Activity::findOrFail($this->activityId)->delete();
            session()->flash('success', 'Data kegiatan berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/activity', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/activity', navigate: true);
        }
    }

    #[On('forceDelete')]
    public function forceDelete()
    {
        Activity::findOrFail($this->activityId)->delete();
        session()->flash('success', 'Data aktivitas berhasil dihapus.');
        $this->showModal = false;
        return $this->redirect('/admin/activity', navigate: true);
    }
}
