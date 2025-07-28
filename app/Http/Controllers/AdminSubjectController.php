<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminSubjectController extends Controller
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
                    'code' => $row[1]
                ];
            }
            fclose($file);


            $dataSubject = [];

            foreach ($data as $subject) {
                $validator = Validator::make($subject, [
                    'name' => 'required',
                    'code' => 'required',
                ]);

                if ($validator->fails()) {
                    session()->flash('error', 'Gagal unggah data mata pelajaran, ada data yang tidak valid: ' . implode(', ', $validator->errors()->all()));
                    return redirect('/admin/subject');
                }

                if (Subject::where('name', $subject['name'])->exists()) {
                    session()->flash('error', 'Gagal upload data mata pelajaran: ' . $subject['name'] . ' sudah ada');
                    return redirect('/admin/subject');
                }



                if (Subject::where('code', $subject['code'])->exists()) {
                    session()->flash('error', 'Gagal upload data mata pelajaran: ' . $subject['code'] . ' sudah ada');
                    return redirect('/admin/subject');
                }

                $dataSubject[] = [
                    'name' => $subject['name'],
                    'code' => $subject['code'],
                ];
            }



            DB::transaction(function () use ($dataSubject) {
                foreach ($dataSubject as $subject) {
                    Subject::create($subject);
                }
            });

            session()->flash('success', 'Berhasil mengunggah data mata pelajaran');
            return redirect('/admin/subject');
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem upload grade: ' . $e->getMessage());
            return redirect('/admin/subject');
        }
    }
}
