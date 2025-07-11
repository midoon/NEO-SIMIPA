<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminStudentController extends Controller
{
    public function uploadFile(Request $request)
    {

        try {
            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            $file = fopen($request->file('file')->getRealPath(), 'r');
            $header = fgetcsv($file);

            $data = [];
            while ($row = fgetcsv($file)) {
                $data[] = [
                    'name' => $row[0],
                    'nisn' => $row[1],
                    'gender' => strtolower($row[2]),
                    'group' => $row[3],
                ];
            }
            fclose($file);



            // filter for duplicate nik and gender validation

            $dataStudent = [];

            foreach ($data as $student) {
                $validator = Validator::make($student, [
                    'name' => 'required',
                    'nisn' => 'required|numeric',
                    'gender' => 'required|in:perempuan,laki-laki',
                    'group' => 'required',

                ]);

                if ($validator->fails()) {
                    session()->flash('error', 'Gagal unggah data siswa, ada data yang tidak valid: ' . implode(', ', $validator->errors()->all()));
                    return redirect('/admin/student');
                }
                if (Student::where('nisn', $student['nisn'])->exists()) {
                    session()->flash('error', 'Gagal upload data siswa: ' . $student['nisn'] . ' sudah ada');
                    return redirect('/admin/student');
                }

                $group = Group::where('name', $student['group'])->first();

                if (!$group) {
                    session()->flash('error', 'Gagal upload data rombel: ' . $student['group'] . ' tidak ditemukan');
                    return redirect('/admin/student');
                }

                $dataStudent[] = [
                    'name' => $student['name'],
                    'group_id' => $group->id,
                    'nisn' => $student['nisn'],
                    'gender' => $student['gender']
                ];
            }





            DB::transaction(function () use ($dataStudent) {
                foreach ($dataStudent as $student) {
                    Student::create($student);
                }
            });

            session()->flash('success', 'Berhasil mengunggah data siswa');
            return redirect('/admin/student');
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem upload siswa: ' . $e->getMessage());
            return redirect('/admin/siswa');
        }
    }
}
