<?php

namespace App\Livewire\Admin\Subject;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminSubjectDelete extends Component
{
    public $showModal = false;
    public $subjectId;

    public function render()
    {
        return view('livewire.admin.subject.admin-subject-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->subjectId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            $existData = [];
            if (DB::table('schedules')->where('subject_id', $this->subjectId)->exists()) {
                array_push($existData, 'jadwal');
            }


            if (count($existData) != 0) {
                $this->dispatch('confirmDelete', [
                    'message' => "Data mata pelajaran yang ingin anda hapus masih digunakan di data " . implode(", ", $existData)
                ]);
                return;
            }

            Subject::findOrFail($this->subjectId)->delete();
            session()->flash('success', 'Data mata pelajaran berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/subject', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/subject', navigate: true);
        }
    }

    #[On('forceDelete')]
    public function forceDelete()
    {
        Subject::findOrFail($this->subjectId)->delete();
        session()->flash('success', 'Data rombel berhasil dihapus.');
        $this->showModal = false;
        return $this->redirect('/admin/subject', navigate: true);
    }
}
