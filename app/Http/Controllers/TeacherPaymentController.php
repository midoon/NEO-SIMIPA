<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherPaymentController extends Controller
{
    public function genereateReceipt(Request $request)
    {
        $request->validate([
            'feeId'    => 'required',

        ]);

        $feeId = $request->query('feeId');
        $fee = Fee::find($feeId);
        if (!$fee) {
            return back()->withErrors(['error' => 'Biaya tidak ditemukan.']);
        }
        $receipt = DB::table('receipts')->where('fee_id', $fee->id)->first();
        if (!$receipt) {
            return back()->withErrors(['error' => 'Pembayaran belum lunas']);
        }

        $teacherId = session('teacher')['teacherId'];

        $teacher = Teacher::find($teacherId);
        $student = $fee->student;
        $group = $student->group;
        $grade = $group->grade;
        $paymentType = $fee->paymentType;

        $dataReceipt = [
            'receipt_number' => $receipt->receipt_number,
            'receipt_date' => $receipt->created_at,
            'name' => $student->name,
            'group_name' => $group->name,
            'grade_name' => $grade->name,
            'amount' => $fee->amount,
            'teacher_name' => $teacher->name,
            'payment_type' => $paymentType->name,
        ];

        $pdf = Pdf::setOption('enable-local-file-access', true)->loadView('livewire.teacher.payment.read.receipt_template', [
            'dataReceipt' => $dataReceipt,
        ]);

        return $pdf->download($student->name . '_' . $group->name . '_' . $paymentType->name . '_kwitansi_.pdf');
    }
}
