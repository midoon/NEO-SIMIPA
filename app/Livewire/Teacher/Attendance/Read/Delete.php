<?php

namespace App\Livewire\Teacher\Attendance\Read;

use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public $showModal = false;
    public $activity;
    public $group;
    public $statuses = [];


    public function render()
    {
        return view('livewire.teacher.attendance.read.delete');
    }

    #[On('openConfirmDelete')]
    public function openModal($group, $activity, $statuses)
    {
        $this->group = $group;
        $this->activity = $activity;
        $this->statuses = $statuses;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function destroy()
    {
        try {

            if (count($this->statuses) == 0) {
                $params = [
                    'groupId' => $this->groupId,
                    'activityId' => $this->activityId,
                    'date' => $this->date,
                ];
                session()->flash('error', 'Tidak ada data presensi');
                return redirect()->to(
                    '/teacher/attendance/read?' . http_build_query($params)
                );
            }

            DB::transaction(function () {
                foreach ($this->statuses as  $key => $value) {
                    DB::table('attendances')->where('id', $key)->delete();
                }
            });

            session()->flash('success', 'Presensi berhasil dihapus');
            $this->redirect('/teacher/attendance');
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem attendance: ' . $e->getMessage());
            $this->redirect('/teacher/attendance');
        }
    }
}
