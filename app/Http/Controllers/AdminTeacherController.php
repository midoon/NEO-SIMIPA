<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminTeacherController extends Controller
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
                    'nik' => $row[1],
                    'gender' => strtolower($row[2]),
                    'role' => ['guru'],
                ];
            }
            fclose($file);



            // filter for duplicate nik and gender validation

            foreach ($data as $teacher) {
                $validator = Validator::make($teacher, [
                    'name' => 'required',
                    'nik' => 'required|numeric',
                    'gender' => 'required|in:perempuan,laki-laki'
                ]);

                if ($validator->fails()) {
                    session()->flash('error', 'Gagal unggah data guru, ada data yang tidak valid: ' . implode(', ', $validator->errors()->all()));
                    return redirect('/admin/teacher');
                }

                if (Teacher::where('nik', $teacher['nik'])->exists()) {
                    session()->flash('error', 'Gagal unggah data guru, NIK ' . $teacher['nik'] . ' sudah ada');
                    return redirect('/admin/teacher');
                }
            }

            DB::transaction(function () use ($data) {
                foreach ($data as $teacher) {
                    Teacher::create($teacher);
                }
            });

            session()->flash('success', 'Berhasil mengunggah data guru');
            return redirect('/admin/teacher');
        } catch (Exception $e) {
            session()->flash('error', 'Gagal mengunggah data guru: ' . $e->getMessage());
            return redirect('/admin/teacher');
        }
    }
}
