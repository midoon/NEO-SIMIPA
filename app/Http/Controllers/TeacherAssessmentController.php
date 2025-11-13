<?php

namespace App\Http\Controllers;

use App\Models\AssessmentType;
use App\Models\Group;
use App\Models\Subject;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherAssessmentController extends Controller
{
    public function generateReport(Request $request)
    {
        $request->validate([
            'groupId'    => 'required',
            'assessmentTypeId'    => 'required',
            'subjectId'    => 'required',
        ]);

        $groupId = $request->query('groupId');
        $assessmentTypeId = $request->query('assessmentTypeId');
        $subjectId = $request->query('subjectId');

        $group = Group::find($groupId);
        if (!$group) {
            session()->flash('error', "Kelas tidak ditemukan");
            return back()->withErrors(['error' => 'Rombel tidak ditemukan.']);
        }

        $assessmentType = AssessmentType::find($assessmentTypeId);
        if (!$assessmentType) {
            session()->flash('error', "Tipe penilaian tidak tersedia untuk kelas ini");
            return back()->withErrors(['error' => 'tipe penilaian tidak ditemukan.']);
        }

        $subject = Subject::find($subjectId);
        if (!$subject) {
            session()->flash('error', "Mata pelajaran tidak tersedia untuk kelas ini");
            return back()->withErrors(['error' => 'mata pelajaran tidak ditemukan.']);
        }

        $students = DB::table('students')
            ->join('groups', 'students.group_id', '=', 'groups.id')
            ->where('students.group_id', $groupId)
            ->select('students.*', 'groups.name as group_name')
            ->orderBy('students.name')->get();

        $studentScore = [];

        foreach ($students as $student) {
            $score = DB::table('assessment_scores')
                ->where('student_id', $student->id)
                ->where('assessment_type_id', $assessmentTypeId)
                ->where('subject_id', $subjectId)
                ->first();

            $studentScore[$student->id] = [
                'student_name' => $student->name,
                'student_nisn' => $student->nisn,
                'score' => $score ? $score->score : 0,
            ];
        }

        // return view('livewire.teacher.assessment.report.report_template', [
        //     'group' => $group,
        //     'assessmentType' => $assessmentType,
        //     'subject' => $subject,
        //     'studentScores' => $studentScore,
        // ]);

        $pdf = Pdf::setOption('enable-local-file-access', true)->loadView('livewire.teacher.assessment.report.report_template', [

            'group' => $group,
            'assessmentType' => $assessmentType,
            'subject' => $subject,
            'studentScores' => $studentScore,
        ]);

        return $pdf->download('Laporan_Penilaian_' . $group->name . '_' . $assessmentType->name . '_' . $subject->name . '.pdf');
    }
}
