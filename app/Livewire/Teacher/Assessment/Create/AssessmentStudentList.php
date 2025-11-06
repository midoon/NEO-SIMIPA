<?php

namespace App\Livewire\Teacher\Assessment\Create;

use App\Models\AssessmentType;
use App\Models\Group;
use App\Models\Subject;
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
    public $groupId, $assessmentTypeId, $date, $subjectId;

    public $group, $assessmentType, $students, $subject;
    protected $rules = [
        'groupId' => 'required',
        'assessmentTypeId' => 'required',
        'subjectId' => 'required',
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

        $this->subject = Subject::find($this->subjectId);
        if (!$this->subject) {
            session()->flash('error', "Mata pelajaran tidak tersedia untuk kelas ini");
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
            'subject' => $this->subject,
            'date' => $this->date,
        ]);
    }

    public function showModalScore($studentId)
    {
        $this->dispatch('openModalInputScore', $studentId, $this->assessmentTypeId, $this->subjectId);
    }
}
