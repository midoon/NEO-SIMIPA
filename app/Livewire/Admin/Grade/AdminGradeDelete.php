<?php

namespace App\Livewire\Admin\Grade;

use App\Models\Grade;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGradeDelete extends Component
{
    public $showModal = false;
    public $gradeId;

    public function render()
    {
        return view('livewire.admin.grade.admin-grade-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->gradeId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {

            $existData = [];
            if (DB::table('groups')->where('grade_id', $this->gradeId)->exists()) {
                array_push($existData, 'kelas');
            }

            if (DB::table('grade_fees')->where('grade_id', $this->gradeId)->exists()) {
                array_push($existData, 'tagihan kelas');
            }

            if (count($existData) != 0) {
                $this->dispatch('confirmDelete', [
                    'message' => "Data kelas yang ingin anda hapus masih digunakan di data " . implode(", ", $existData)
                ]);
                return;
            }



            Grade::findOrFail($this->gradeId)->delete();
            session()->flash('success', 'Data kelas berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/grade', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/grade', navigate: true);
        }
    }

    #[On('forceDelete')]
    public function forceDelete()
    {
        Grade::findOrFail($this->gradeId)->delete();
        session()->flash('success', 'Data kelas berhasil dihapus.');
        $this->showModal = false;
        return $this->redirect('/admin/grade', navigate: true);
    }
}
