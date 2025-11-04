<?php

namespace App\Livewire\Teacher\Assessment;

use App\Models\AssessmentType;
use App\Models\Group;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateFormFilter extends Component
{
    public $showModal = false;
    public $groupId, $assessmentTypeId, $date = [];

    public function mount()
    {
        $this->date = Carbon::now()->format('Y-m-d'); // contoh: 17-08-2025
    }

    public function render()
    {
        $teacherId = session('teacher')['teacherId'];
        $groups =  Group::whereHas('schedules', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('name')->get();
        $assessmentTypes = AssessmentType::orderBy('name')->get();
        return view('livewire.teacher.assessment.create-form-filter', ['groups' => $groups, 'assessmentTypes' => $assessmentTypes]);
    }

    #[On('openFilterCreate')]
    public function createModal()
    {
        // $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->groupId = '';
        $this->assessmentTypeId = '';
        $this->date = '';
    }

    public function create()
    {

        // validasi
        $this->validate([
            'groupId' => 'required|exists:groups,id',
            'assessmentTypeId' => 'required|exists:assessment_types,id',
            'date' => 'required|date',
        ]);



        $params = [
            'groupId' => $this->groupId,
            'assessmentTypeId' => $this->assessmentTypeId,
            'date' => $this->date,
        ];

        return redirect()->to('/teacher/assessment/create?' . http_build_query($params));
    }
}
