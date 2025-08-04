<?php

namespace App\Http\Controllers;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminPaymentTypeController extends Controller
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


            $dataPT = [];

            foreach ($data as $pt) {
                $validator = Validator::make($pt, [
                    'name' => 'required',

                ]);

                if ($validator->fails()) {
                    session()->flash('error', 'Gagal unggah data tipe pembayaran, ada data yang tidak valid: ' . implode(', ', $validator->errors()->all()));
                    return redirect('/admin/payment/type');
                }

                if (PaymentType::where('name', $pt['name'])->exists()) {
                    session()->flash('error', 'Gagal upload data tipe pembayaran : ' . $pt['name'] . ' sudah ada');
                    return redirect('/admin/payment/type');
                }

                $description = $pt['description'] ?? '';
                if ($description === '') {
                    $description = $pt['name'];
                }



                $dataPT[] = [
                    'name' => $pt['name'],
                    'description' => $description,
                ];
            }



            DB::transaction(function () use ($dataPT) {
                foreach ($dataPT as $pt) {
                    PaymentType::create($pt);
                }
            });

            session()->flash('success', 'Berhasil mengunggah data tipe pembayaran');
            return redirect('/admin/payment/type');
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem upload payment type: ' . $e->getMessage());
            return redirect('/admin/payment/type');
        }
    }
}
