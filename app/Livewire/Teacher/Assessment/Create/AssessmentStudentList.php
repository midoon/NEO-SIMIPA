<?php

namespace App\Livewire\Teacher\Assessment\Create;

use App\Models\AssessmentType;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class AssessmentStudentList extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Payment')]

    #[Url()]
    public $groupId, $assessmentTypeId, $date;

    public $group, $assessmentType, $students;
    protected $rules = [
        'groupId' => 'required',
        'assessmentTypeId' => 'required',
        'date' => 'required',
    ];

    protected $listeners = ['refreshParent' => '$refresh'];

    public function mount()
    {
        $this->validate();

        $this->group = Group::find($this->groupId);
        if (!$this->group) {
            session()->flash('error', "Kelas tidak ditemukan");
            return $this->redirect('/teacher/assessment', navigate: true);
        }

        $this->assessmentType = AssessmentType::find($this->assessmentTypeId);
        if (!$this->assessmentType) {
            session()->flash('error', "Tipe penilaian tidak tersedia untuk kelas ini");
            return $this->redirect('/teacher/assessment', navigate: true);
        }

        $this->students = DB::table('students')
            ->join('groups', 'students.group_id', '=', 'groups.id')
            ->where('students.group_id', $this->groupId)
            ->select('students.*', 'groups.name as group_name')
            ->orderBy('students.name')->get();
    }

    public function render()
    {
        return view('livewire.teacher.assessment.create.assessment-student-list', [
            'students' => $this->students,
            'group' => $this->group,
            'assessmentType' => $this->assessmentType,
            'date' => $this->date,
        ]);
    }

    public function showModalScore($studentId)
    {
        $this->dispatch('openModalInputScore', $studentId, $this->assessmentTypeId);
    }
}
