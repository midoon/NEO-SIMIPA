<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminGradeController extends Controller
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
                ];
            }
            fclose($file);


            // filter for duplicate nik and gender validation

            foreach ($data as $grade) {
                $validator = Validator::make($grade, [
                    'name' => 'required',
                ]);

                if ($validator->fails()) {
                    session()->flash('error', 'Gagal unggah data kelas, ada data yang tidak valid: ' . implode(', ', $validator->errors()->all()));
                    return redirect('/admin/grade');
                }

                if (Grade::where('name', $grade['name'])->exists()) {
                    session()->flash('error', 'Gagal upload data kelas: ' . $grade['name'] . ' sudah ada');
                    return redirect('/admin/grade');
                }
            }

            DB::transaction(function () use ($data) {
                foreach ($data as $teacher) {
                    Grade::create($teacher);
                }
            });

            session()->flash('success', 'Berhasil mengunggah data guru');
            return redirect('/admin/grade');
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem upload grade: ' . $e->getMessage());
            return redirect('/admin/grade');
        }
    }
}
