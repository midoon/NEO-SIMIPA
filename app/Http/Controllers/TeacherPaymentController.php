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

    public function generateReport(Request $request)
    {
        $request->validate([
            'groupId'    => 'required',
            'paymentTypeId'    => 'required',
        ]);

        $groupId = $request->query('groupId');
        $paymentTypeId = $request->query('paymentTypeId');

        $teacherId = session('teacher')['teacherId'];
        $teacher = Teacher::find($teacherId);

        $group = DB::table('groups')->where('id', $groupId)->first();
        if (!$group) {
            return back()->withErrors(['error' => 'Rombel tidak ditemukan.']);
        }
        $paymentType = DB::table('payment_types')->where('id', $paymentTypeId)->first();
        if (!$paymentType) {
            return back()->withErrors(['error' => 'Tipe pembayaran tidak ditemukan.']);
        }

        $studentFees = DB::table('fees')->join('students', 'fees.student_id', '=', 'students.id')->select('fees.*', 'students.name as student_name', 'students.nisn as student_nisn')->join('groups', 'students.group_id', '=', 'groups.id')->where('groups.id', $groupId)->where('fees.payment_type_id', $paymentTypeId)->orderBy('students.name', 'asc')->get();

        $totalAmount = 0;
        $totalPaid = 0;
        foreach ($studentFees as $fee) {
            $totalAmount += $fee->amount;
            $totalPaid += $fee->paid_amount;
        }

        $dataReport = [
            'studentFees' => $studentFees,
            'totalAmount' => $totalAmount,
            'totalPaid' => $totalPaid,
            'group' => $group,
            'paymentType' => $paymentType,
            'teacher' => $teacher,
        ];

        $pdf = Pdf::setOption('enable-local-file-access', true)->loadView('livewire.teacher.payment.report.report_template', [
            'studentFees' => $studentFees,
            'totalAmount' => $totalAmount,
            'totalPaid' => $totalPaid,
            'group' => $group,
            'paymentType' => $paymentType,
            'teacher' => $teacher,
        ]);

        return $pdf->download('Rekap_Pembayaran_' . $group->name . '_' . $paymentType->name . '.pdf');
    }
}
