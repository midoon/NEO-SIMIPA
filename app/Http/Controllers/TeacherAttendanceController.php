<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Group;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherAttendanceController extends Controller
{
    public function generateReport(Request $request)
    {

        try {
            $request->validate([
                'groupId'    => 'required|exists:groups,id',
                'activityId' => 'required|exists:activities,id',
                'dateStart'  => 'required|date',
                'dateEnd'    => 'required|date|after_or_equal:dateStart',
            ]);

            $groupId = $request->query('groupId');
            $activityId = $request->query('activityId');
            $dateStart = $request->query('dateStart');
            $dateEnd = $request->query('dateEnd');

            $groupName = Group::find($groupId)->name;
            $activityName = Activity::find($activityId)->name;

            $attendances = DB::table('attendances')
                ->join('students', 'attendances.student_id', '=', 'students.id')
                ->select(
                    'attendances.*',
                    'students.name as student_name',
                    'students.nisn as student_nisn'
                )
                ->where('attendances.group_id', $groupId)
                ->where('attendances.activity_id', $activityId)
                ->whereBetween('attendances.date', [$dateStart, $dateEnd])
                ->orderBy('students.name', 'asc')
                ->get();

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

            $pdf = Pdf::loadView('livewire.teacher.attendance.report.report_template',  ['reportMap' => $reportMap, 'groupName' => $groupName, 'activityName' => $activityName, 'dateStart' => $dateStart, 'dateEnd' => $dateEnd]);
            return $pdf->download('laporan-presensi.pdf');
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect('/teacher/attendance');
        }
    }
}
