<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Group;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminGroupController extends Controller
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
                    'grade' => $row[1],
                ];
            }
            fclose($file);


            // filter for duplicate nik and gender validation

            $dataGroup = [];

            foreach ($data as $group) {
                $validator = Validator::make($group, [
                    'name' => 'required',
                    'grade' => 'required',

                ]);

                if ($validator->fails()) {
                    session()->flash('error', 'Gagal unggah data rombel, ada data yang tidak valid: ' . implode(', ', $validator->errors()->all()));
                    return redirect('/admin/group');
                }
                if (Group::where('name', $group['name'])->exists()) {

                    session()->flash('error', 'Gagal upload data rombel: ' . $group['name'] . ' sudah ada');
                    return redirect('/admin/group');
                }

                $grade = Grade::where('name', $group['grade'])->first();
                if (!$grade) {
                    session()->flash('error', 'Gagal upload data rombel: ' . $group['grade'] . ' tidak ditemukan');
                    return redirect('/admin/group');
                }

                $dataGroup[] = [
                    'name' => $group['name'],
                    'grade_id' => $grade->id,
                ];
            }


            DB::transaction(function () use ($dataGroup) {
                foreach ($dataGroup as $group) {
                    Group::create($group);
                }
            });

            session()->flash('success', 'Berhasil mengunggah data kelas');
            return redirect('/admin/group');
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem upload kelas: ' . $e->getMessage());
            return redirect('/admin/group');
        }
    }
}
