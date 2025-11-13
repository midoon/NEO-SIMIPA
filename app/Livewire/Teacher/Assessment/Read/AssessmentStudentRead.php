<?php

namespace App\Livewire\Teacher\Assessment\Read;

use App\Models\AssessmentType;
use App\Models\Group;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class AssessmentStudentRead extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Assessment')]

    #[Url()]
    public $groupId, $assessmentTypeId,  $subjectId;

    public $group, $assessmentType, $students, $subject;

    public $studentScore = [];

    protected $rules = [
        'groupId' => 'required',
        'assessmentTypeId' => 'required',
        'subjectId' => 'required',

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

        foreach ($this->students as $student) {
            $score = DB::table('assessment_scores')
                ->where('student_id', $student->id)
                ->where('assessment_type_id', $this->assessmentTypeId)
                ->where('subject_id', $this->subjectId)
                ->first();

            $this->studentScore[$student->id] = [
                'student_name' => $student->name,
                'student_nisn' => $student->nisn,
                'score' => $score ? $score->score : 0,
            ];
        }
    }

    public function render()
    {
        return view('livewire.teacher.assessment.read.assessment-student-read',  [
            'studentScores' => $this->studentScore,
            'group' => $this->group,
            'assessmentType' => $this->assessmentType,
            'subject' => $this->subject,

        ]);
    }
}
