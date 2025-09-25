<?php

namespace App\Livewire\Teacher\Payment\Report;

use App\Models\Group;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class PaymentReportList extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Payment')]

    #[Url()]
    public $groupId, $paymentTypeId;

    public $studentFees, $totalAmount = 0, $totalPaid = 0, $group;

    public function mount()
    {
        try {

            $this->group = Group::find($this->groupId);

            $this->studentFees = DB::table('fees')->join('students', 'fees.student_id', '=', 'students.id')->select('fees.*', 'students.name as student_name', 'students.nisn as student_nisn')->join('groups', 'students.group_id', '=', 'groups.id')->where('groups.id', $this->groupId)->where('fees.payment_type_id', $this->paymentTypeId)->orderBy('students.name', 'asc')->get();

            foreach ($this->studentFees as $fee) {
                $this->totalAmount += $fee->amount;
                $this->totalPaid += $fee->paid_amount;
            }

            $gradeId = $this->group->grade_id;
            $gradeFee = DB::table('grade_fees')
                ->where('grade_id', $gradeId)
                ->where('payment_type_id', $this->paymentTypeId)
                ->first();
            if (!$gradeFee) {
                session()->flash('error', "Tipe tagihan pembayaran tidak tersedia untuk kelas ini");
                return $this->redirect('/teacher/payment', navigate: true);
            }
        } catch (Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            $this->redirect('/teacher/payment', navigate: true);
        }
    }
    public function render()
    {

        return view('livewire.teacher.payment.report.payment-report-list', [
            'studentFees' => $this->studentFees,
            'totalAmount' => $this->totalAmount,
            'totalPaid' => $this->totalPaid,
            'group' => $this->group,
        ]);
    }
}
