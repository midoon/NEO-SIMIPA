<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminTeacherDelete extends Component
{


    public $showModal = false;
    public $isInterrupt = false;
    public $messageDelete = "";
    public $teacherId;

    public function render()
    {
        return view('livewire.admin.teacher.admin-teacher-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->teacherId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {

            $existData = [];
            if (DB::table('schedules')->where('teacher_id', $this->teacherId)->exists()) {
                array_push($existData, 'jadwal');
            }

            if (count($existData) != 0) {
                $this->dispatch('confirmDelete', [
                    'message' => "Guru yang ingin anda hapus masih digunakan di data " . implode(", ", $existData)
                ]);
                return;
            }


            Teacher::findOrFail($this->teacherId)->delete();
            session()->flash('success', 'Data guru berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/teacher', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem teacher delete: ' . $e->getMessage());
            return $this->redirect('/admin/teacher', navigate: true);
        }
    }

    #[On('forceDelete')]
    public function forceDelete()
    {
        Teacher::findOrFail($this->teacherId)->delete();
        session()->flash('success', 'Data guru berhasil dihapus.');
        $this->showModal = false;
        return $this->redirect('/admin/teacher', navigate: true);
    }
}
