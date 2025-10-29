<?php

namespace App\Livewire\Admin\AssessmentType;

use App\Models\AssessmentType;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminAssessmentTypeDelete extends Component
{
    public $showModal = false;
    public $assessmentTypeId;
    public function render()
    {
        return view('livewire.admin.assessment-type.admin-assessment-type-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->assessmentTypeId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            $existData = [];
            if (DB::table('assessment_scores')->where('assessment_type_id', $this->assessmentTypeId)->exists()) {
                array_push($existData, 'nilai');
            }


            if (count($existData) != 0) {
                $this->dispatch('confirmDelete', [
                    'message' => "Data tipe penilaian yang ingin anda hapus masih digunakan di data " . implode(", ", $existData)
                ]);
                return;
            }

            AssessmentType::findOrFail($this->assessmentTypeId)->delete();
            session()->flash('success', 'Data tipe penilaian berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/assessment/type', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/assessment/type', navigate: true);
        }
    }

    #[On('forceDelete')]
    public function forceDelete()
    {
        AssessmentType::findOrFail($this->assessmentTypeId)->delete();
        session()->flash('success', 'Data tipe penilaian berhasil dihapus.');
        $this->showModal = false;
        return $this->redirect('/admin/assessment/type', navigate: true);
    }
}
