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
    public $studentId, $paymentTypeId;
    protected $rules = [
        'studentId' => 'required',
        'paymentTypeId' => 'required',
    ];

    // menampilkan list payment yg telah dilakukan siswa
    public function render()
    {
        $student = Student::find($this->studentId);
        $fee = DB::table("fees")->where("student_id", $this->studentId)->where("payment_type_id", $this->paymentTypeId)->first();
        $paymentType = PaymentType::find($this->paymentTypeId);
        $payments = Payment::orderBy("created_at")->where("student_id", $this->studentId)->where("fee_id", $fee->id)->get();
        return view('livewire.teacher.payment.read.payment-read-list', [
            "student" => $student,
            "fee" => $fee,
            "payments" => $payments,
            "paymentType" => $paymentType
        ]);
    }
}
