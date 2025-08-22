<?php

namespace App\Livewire\Teacher\Attendance\Read;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Group;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class AttendanceStudentRead extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Attendance')]

    #[Url()] // mengambil nilai dari query param dan ditaruh langsung ke $grade_id
    public $groupId, $activityId, $date;

    public $cStudent = 0, $cHadir = 0, $cSakit = 0, $cIzin = 0, $cAlpha = 0;

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
                ->where('attendances.date', $this->date)
                ->orderBy('students.name', 'asc')
                ->get();


            foreach ($attendances as $atId) {
                if (!isset($this->statuses[$atId->id])) {
                    $this->statuses[$atId->id] = $atId->status;
                }
            }

            // hitung progress
            $this->updateCounters();


            $group = Group::where('id', $this->groupId)->value('name');
            $activity = Activity::where('id', $this->activityId)->value('name');

            return view('livewire.teacher.attendance.read.attendance-student-read', ['attendances' => $attendances, 'group' => $group, 'activity' => $activity]);
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem attendance: ' . $e->getMessage());
            $this->redirect('/teacher/attendance');
        }
    }

    public function updatedStatuses()
    {
        // setiap kali ada perubahan di wire:model statuses, langsung update counter
        $this->updateCounters();
    }

    private function updateCounters()
    {
        // reset counter sebelum dihitung ulang
        $this->cStudent = count($this->statuses);
        $this->cHadir = $this->cSakit = $this->cIzin = $this->cAlpha = 0;

        foreach ($this->statuses as $st) {
            switch ($st) {
                case 'hadir':
                    $this->cHadir++;
                    break;
                case 'sakit':
                    $this->cSakit++;
                    break;
                case 'izin':
                    $this->cIzin++;
                    break;
                case 'alpha':
                    $this->cAlpha++;
                    break;
            }
        }
    }

    public function update()
    {
        try {

            if (count($this->statuses) == 0) {
                $params = [
                    'groupId' => $this->groupId,
                    'activityId' => $this->activityId,
                    'date' => $this->date,
                ];
                session()->flash('error', 'Tidak ada data presensi');
                return redirect()->to(
                    '/teacher/attendance/read?' . http_build_query($params)
                );
            }

            DB::transaction(function () {
                foreach ($this->statuses as  $key => $value) {
                    Attendance::where('id', $key)->update([
                        'status' => $value
                    ]);
                }
            });

            session()->flash('success', 'Presensi berhasil disimpan');
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem attendance: ' . $e->getMessage());
            $this->redirect('/teacher/attendance');
        }
    }

    public function destroy()
    {
        try {

            if (count($this->statuses) == 0) {
                $params = [
                    'groupId' => $this->groupId,
                    'activityId' => $this->activityId,
                    'date' => $this->date,
                ];
                session()->flash('error', 'Tidak ada data presensi');
                return redirect()->to(
                    '/teacher/attendance/read?' . http_build_query($params)
                );
            }

            DB::transaction(function () {
                foreach ($this->statuses as  $key => $value) {
                    DB::table('attendances')->where('id', $key)->delete();
                }
            });

            session()->flash('success', 'Presensi berhasil dihapus');
            $this->redirect('/teacher/attendance');
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem attendance: ' . $e->getMessage());
            $this->redirect('/teacher/attendance');
        }
    }
}
