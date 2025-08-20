<?php

namespace App\Livewire\Teacher\Attendance\Create;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Group;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class AttendanceStudentList extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Attendance')]

    #[Url()] // mengambil nilai dari query param dan ditaruh langsung ke $grade_id
    public $groupId, $activityId, $date;

    public $statuses = [];

    protected $rules = [
        'groupId' => 'required',
        'activityId' => 'required',
        'date' => 'required'
    ];

    public function render()
    {
        try {
            $this->validate();

            $isCreated = DB::table('attendances')->where('group_id', $this->groupId)->where('activity_id', $this->activityId)->where('date', $this->date)->count();

            if ($isCreated) {
                session()->flash('error', 'Presensi telah dibuat');
                $this->redirect('/teacher/attendance', navigate: true);
            }

            $teacherId = session('teacher')['teacherId'];

            $correctGroup = Group::whereHas('schedules', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })->where('id', $this->groupId)->count();

            if ($correctGroup == 0) {
                session()->flash('error', 'Anda tidak memiliki akses ke kelas ini');
                $this->redirect('/teacher/attendance', navigate: true);
            }

            $students = DB::table('students')->where('group_id', $this->groupId)->orderBy('name')->get();
            // kasih default status "hadir" kalau belum ada
            foreach ($students as $s) {
                if (!isset($this->statuses[$s->id])) {
                    $this->statuses[$s->id] = 'hadir';
                }
            }

            $group = Group::find($this->groupId);
            $activity = Activity::find($this->activityId);

            return view('livewire.teacher.attendance.create.attendance-student-list', ['students' => $students, 'group' => $group, 'activity' => $activity]);
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem attendance: ' . $e->getMessage());
            $this->redirect('/teacher/attendance');
        }
    }

    public function save()
    {
        $this->validate();


        // Pastikan data siswa ada
        $students = DB::table('students')
            ->where('group_id', $this->groupId)
            ->pluck('id');


        foreach ($students as $studentId) {
            Attendance::create([
                'student_id' => $studentId,
                'group_id' => $this->groupId,
                'activity_id' => $this->activityId,
                'date' => $this->date,
                'status' => $this->statuses[$studentId] ?? 'alpha', // default kalau ga dipilih
            ]);
        }

        session()->flash('success', 'Presensi berhasil disimpan');
        $this->redirect('/teacher/attendance', navigate: true);
    }
}
