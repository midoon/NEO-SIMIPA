<?php

namespace App\Livewire\Teacher\Assessment;

use App\Models\AssessmentType;
use App\Models\Group;
use App\Models\Subject;
use Livewire\Attributes\On;
use Livewire\Component;

class ReportFormFilter extends Component
{
    public $showModal = false;
    public $groupId, $assessmentTypeId,  $subjectId = [];

    public function render()
    {
        $teacherId = session('teacher')['teacherId'];
        $groups =  Group::whereHas('schedules', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('name')->get();
        $subjects = Subject::whereHas('schedules', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('name')->get();
        $assessmentTypes = AssessmentType::orderBy('name')->get();

        return view('livewire.teacher.assessment.report-form-filter', ['groups' => $groups, 'assessmentTypes' => $assessmentTypes, 'subjects' => $subjects]);
    }

    #[On('openFilterReport')]
    public function reportModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->groupId = '';
        $this->assessmentTypeId = '';
    }

    public function report()
    {
        // validasi
        $this->validate([
            'groupId' => 'required|exists:groups,id',
            'assessmentTypeId' => 'required|exists:assessment_types,id',
            'subjectId' => 'required|exists:subjects,id',
        ]);

        $params = [
            'groupId' => $this->groupId,
            'assessmentTypeId' => $this->assessmentTypeId,
            'subjectId' => $this->subjectId,
        ];

        return redirect()->to('/teacher/assessment/report?' . http_build_query($params));
    }
}
