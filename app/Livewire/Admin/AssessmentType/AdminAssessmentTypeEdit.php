<?php

namespace App\Livewire\Admin\AssessmentType;

use App\Models\AssessmentType;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminAssessmentTypeEdit extends Component
{
    public $showModal = false;
    public $name;
    public $code;
    public $assessmentTypeId;

    public function render()
    {
        return view('livewire.admin.assessment-type.admin-assessment-type-edit');
    }

    #[On('openModalEditEvent')]
    public function openModal($id)
    {
        $this->name = '';
        $this->code = '';
        $this->assessmentTypeId = $id;
        $this->showModal = true;

        $at = AssessmentType::find($id);
        if ($at) {
            $this->name = $at->name;
            $this->code = $at->code;
        } else {
            session()->flash('error', 'Tipe penilaian tidak ditemukan.');
            return $this->redirect('/admin/assessment/type', navigate: true);
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:50',
            ]);

            // Check if grade already exists
            if (AssessmentType::where('code', $this->code)->exists() && AssessmentType::where('code', $this->code)->first()->id !== $this->assessmentTypeId) {
                session()->flash('error', "Kode tipe penilaian sudah terdaftar.");
                return $this->redirect('/admin/assessment/type', navigate: true);
            }
            if (AssessmentType::where('name', $this->name)->exists() && AssessmentType::where('name', $this->name)->first()->id !== $this->assessmentTypeId) {
                session()->flash('error', "Kode tipe penilaian sudah terdaftar.");
                return $this->redirect('/admin/assessment/type', navigate: true);
            }




            $at = AssessmentType::find($this->assessmentTypeId);
            if ($at) {
                $at->update(['name' => $this->name, 'code' => $this->code]);
                session()->flash('success', 'Tipe penilaian berhasil diperbarui.');
            } else {
                session()->flash('error', 'Tipe penilaian tidak ditemukan.');
            }

            $this->showModal = false;
            $this->name = '';
            $this->assessmentTypeId = null;
            $this->code = '';
            return $this->redirect('/admin/assessment/type', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem update: ' . $e->getMessage());
            return $this->redirect('/admin/assessment/type', navigate: true);
        }
    }
}
