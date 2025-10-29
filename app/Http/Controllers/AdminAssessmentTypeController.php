<?php

namespace App\Http\Controllers;

use App\Models\AssessmentType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminAssessmentTypeController extends Controller
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


            $dataAssessmentType = [];

            foreach ($data as $at) {
                $validator = Validator::make($at, [
                    'name' => 'required',
                    'code' => 'required',
                ]);

                if ($validator->fails()) {
                    session()->flash('error', 'Gagal unggah data tipe penilaian, ada data yang tidak valid: ' . implode(', ', $validator->errors()->all()));
                    return redirect('/admin/assessment/type');
                }



                if (AssessmentType::where('code', $at['code'])->exists()) {
                    session()->flash('error', 'Gagal upload data tipe penilaian: ' . $at['code'] . ' sudah ada');
                    return redirect('/admin/assessment/type');
                }

                $dataAT[] = [
                    'name' => $at['name'],
                    'code' => $at['code'],
                ];
            }



            DB::transaction(function () use ($dataAT) {
                foreach ($dataAT as $at) {
                    AssessmentType::create($at);
                }
            });

            session()->flash('success', 'Berhasil mengunggah data tipe penilaian');
            return redirect('/admin/assessment/type');
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem upload assessment type: ' . $e->getMessage());
            return redirect('/admin/assessment/type');
        }
    }
}
