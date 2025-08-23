<?php

namespace App\Livewire\Teacher\Attendance\Report;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Group;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class AttendanceStudentReport extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Attendance')]

    #[Url()] // mengambil nilai dari query param dan ditaruh langsung ke $grade_id
    public $groupId, $activityId, $dateStart, $dateEnd;

    public $groupName, $activityName;

    public function render()
    {
        try {
            $this->validate([
                'groupId'    => 'required|exists:groups,id',
                'activityId' => 'required|exists:activities,id',
                'dateStart'  => 'required|date',
                'dateEnd'    => 'required|date|after_or_equal:dateStart',
            ]);

            $teacherId = session('teacher')['teacherId'];

            $correctGroup = Group::whereHas('schedules', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })->where('id', $this->groupId)->count();

            if ($correctGroup == 0) {
                session()->flash('error', 'Anda tidak memiliki akses ke kelas ini');
                $this->redirect('/teacher/attendance', navigate: true);
            }

            $attendances = DB::table('attendances')
                ->join('students', 'attendances.student_id', '=', 'students.id')
                ->select(
                    'attendances.*',
                    'students.name as student_name',
                    'students.nisn as student_nisn'
                )
                ->where('attendances.group_id', $this->groupId)
                ->where('attendances.activity_id', $this->activityId)
                ->whereBetween('attendances.date', [$this->dateStart, $this->dateEnd])
                ->orderBy('students.name', 'asc')
                ->get();

            $this->groupName = Group::find($this->groupId)->name;
            $this->activityName = Activity::find($this->activityId)->name;

            $reportMap = [];
            foreach ($attendances as $at) {
                if (!isset($reportMap[$at->student_id])) {

                    $reportMap[$at->student_id] = [
                        'name' => $at->student_name,
                        'nisn' => $at->student_nisn,
                        'hadir' => 0,
                        'sakit' => 0,
                        'izin' => 0,
                        'alpha' => 0
                    ];
                }

                // Update value berdasarkan status
                if ($at->status == 'hadir') {
                    $reportMap[$at->student_id]['hadir'] += 1;
                } else if ($at->status == 'sakit') {
                    $reportMap[$at->student_id]['sakit'] += 1;
                } else if ($at->status == 'izin') {
                    $reportMap[$at->student_id]['izin'] += 1;
                } else if ($at->status == 'alpha') {
                    $reportMap[$at->student_id]['alpha'] += 1;
                }
            }




            return view('livewire.teacher.attendance.report.attendance-student-report', ['reports' => $reportMap, 'group' => $this->groupName, 'activity' => $this->activityName, 'dateStart' => $this->dateStart, 'dateEnd' => $this->dateEnd]);
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            $this->redirect('/teacher/attendance', navigate: true);
        }
    }
}
