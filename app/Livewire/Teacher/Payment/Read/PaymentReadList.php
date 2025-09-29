<?php

namespace App\Livewire\Teacher\Payment\Read;

use App\Models\Fee;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class PaymentReadList extends Component
{


    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Payment Read')]

    #[Url()] // mengambil nilai dari query param dan ditaruh langsung ke $grade_id
    public $studentId, $paymentTypeId, $feeId;
    protected $rules = [
        'studentId' => 'required',
        'paymentTypeId' => 'required',
    ];


    public $isPaidFull = false, $isBendahara = false;

    protected $listeners = ['refreshParent' => '$refresh'];

    // menampilkan list payment yg telah dilakukan siswa
    public function render()
    {
        if (collect(session('teacher')['role'])->contains('bendahara')) {
            $this->isBendahara = true;
        }
        $student = Student::find($this->studentId);
        $fee = DB::table("fees")->where("student_id", $this->studentId)->where("payment_type_id", $this->paymentTypeId)->first();
        $paymentType = PaymentType::find($this->paymentTypeId);
        $payments = Payment::where('student_id', $this->studentId)
            ->where('fee_id', $fee->id)
            ->orderBy('created_at', 'desc') // terbaru duluan
            ->get();

        $this->feeId = $fee->id;
        if ($fee->status == "paid") {
            $this->isPaidFull = true;
        }
        return view('livewire.teacher.payment.read.payment-read-list', [
            "student" => $student,
            "fee" => $fee,
            "payments" => $payments,
            "paymentType" => $paymentType
        ]);
    }

    public function deleteConnfirmation($id)
    {
        $this->dispatch("openModalDeleteEvent", id: $id);
    }

    public function downloadReceipt()
    {
        $params = [
            'feeId' => $this->feeId,
        ];
        return redirect()->to(
            '/teacher/payment/receipt/generate?' . http_build_query($params)
        );
    }
}
