<?php

namespace App\Livewire\Admin\Group;

use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGroupDelete extends Component
{
    public $showModal = false;
    public $groupId;

    public function render()
    {
        return view('livewire.admin.group.admin-group-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->groupId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {

            $existData = [];
            if (DB::table('schedules')->where('group_id', $this->groupId)->exists()) {
                array_push($existData, 'jadwal');
            }
            if (DB::table('students')->where('group_id', $this->groupId)->exists()) {
                array_push($existData, 'siswa');
            }
            if (DB::table('attendances')->where('group_id', $this->groupId)->exists()) {
                array_push($existData, 'presensi');
            }

            if (count($existData) != 0) {
                $this->dispatch('confirmDelete', [
                    'message' => "Data rombel yang ingin anda hapus masih digunakan di data " . implode(", ", $existData)
                ]);
                return;
            }

            Group::findOrFail($this->groupId)->delete();
            session()->flash('success', 'Data rombel berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/group', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/group', navigate: true);
        }
    }

    #[On('forceDelete')]
    public function forceDelete()
    {
        Group::findOrFail($this->groupId)->delete();
        session()->flash('success', 'Data rombel berhasil dihapus.');
        $this->showModal = false;
        return $this->redirect('/admin/group', navigate: true);
    }
}
