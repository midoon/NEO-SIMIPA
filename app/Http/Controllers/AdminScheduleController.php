<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminScheduleController extends Controller
{
    public function uploadFile(Request $request)
    {


        // ganti cuy buat kode mata pelajaran
        try {
            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);



            $file = fopen($request->file('file')->getRealPath(), 'r');
            $header = fgetcsv($file);

            $data = [];
            while ($row = fgetcsv($file)) {
                $data[] = [
                    'group' => $row[0],
                    'subject' => $row[1],
                    'teacher' => $row[2],
                    'day' => $row[3],
                    'start_time' => str_pad($row[4], 5, '0', STR_PAD_LEFT),
                    'end_time' => str_pad($row[5], 5, '0', STR_PAD_LEFT),
                ];
            }
            fclose($file);

            $dataSchedule = [];




            foreach ($data as $schedule) {
                $validator = Validator::make($schedule, [
                    'group' => 'required',
                    'subject' => 'required',
                    'teacher' => 'required',
                    'day' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu,minggu',
                    'start_time' => 'required|date_format:H:i',
                    'end_time' => 'required|date_format:H:i|after:start_time',
                ]);



                if ($validator->fails()) {
                    session()->flash('error', 'Gagal unggah data jadwal, ada data yang tidak valid: ' . implode(', ', $validator->errors()->all()));
                    return redirect('/admin/schedule');
                }




                $group = Group::where('name', $schedule['group'])->first();

                if (!$group) {
                    session()->flash('error', 'Gagal unggah data rombel: ' . $schedule['group'] . ' tidak ditemukan');
                    return redirect('/admin/schedule');
                }

                $subject = Subject::where('code', $schedule['subject'])->first();
                if (!$subject) {
                    session()->flash('error', 'Gagal unggah data mata pelajaran: ' . $schedule['subject'] . ' tidak ditemukan');
                    return redirect('/admin/schedule');
                }


                $teacher = Teacher::where('nik', $schedule['teacher'])->first();
                if (!$teacher) {
                    session()->flash('error', 'Gagal unggah data guru: ' . $schedule['teacher'] . ' tidak ditemukan');
                    return redirect('/admin/schedule');
                }




                $dataSchedule[] = [
                    'group_id' => $group->id,
                    'subject_id' => $subject->id,
                    'teacher_id' => $teacher->id,
                    'day_of_week' => $schedule['day'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time']
                ];
            }







            DB::transaction(function () use ($dataSchedule) {
                foreach ($dataSchedule as $schedule) {
                    Schedule::create($schedule);
                }
            });

            session()->flash('success', 'Berhasil mengunggah data jadwal');
            return redirect('/admin/schedule');
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem upload jadwal: ' . $e->getMessage());
            return redirect('/admin/schedule');
        }
    }
}
