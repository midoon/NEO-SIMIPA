<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminActivityController extends Controller
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
                    'description' => $row[1]
                ];
            }
            fclose($file);


            $dataActivity = [];

            foreach ($data as $activity) {
                $validator = Validator::make($activity, [
                    'name' => 'required',

                ]);

                if ($validator->fails()) {
                    session()->flash('error', 'Gagal unggah data kegiatan, ada data yang tidak valid: ' . implode(', ', $validator->errors()->all()));
                    return redirect('/admin/activity');
                }

                if (Activity::where('name', $activity['name'])->exists()) {
                    session()->flash('error', 'Gagal upload data kegiatan: ' . $activity['name'] . ' sudah ada');
                    return redirect('/admin/activity');
                }

                $description = $activity['description'] ?? '';
                if ($description === '') {
                    $description = $activity['name'];
                }



                $dataActivity[] = [
                    'name' => $activity['name'],
                    'description' => $description,
                ];
            }



            DB::transaction(function () use ($dataActivity) {
                foreach ($dataActivity as $activity) {
                    Activity::create($activity);
                }
            });

            session()->flash('success', 'Berhasil mengunggah data aktivitas');
            return redirect('/admin/activity');
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem upload grade: ' . $e->getMessage());
            return redirect('/admin/activity');
        }
    }
}
