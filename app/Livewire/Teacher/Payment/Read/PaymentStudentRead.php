<?php

namespace App\Livewire\Teacher\Payment\Read;

use App\Models\Group;
use App\Models\PaymentType;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class PaymentStudentRead extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Payment Read')]

    #[Url()] // mengambil nilai dari query param dan ditaruh langsung ke $grade_id
    public $groupId, $paymentTypeId;

    public $feeId;

    protected $rules = [
        'groupId' => 'required',
        'paymentTypeId' => 'required',
    ];

    public function render()
    {
        try {
            $this->validate();

            // pengecekkan akses
            $teacherId = session('teacher')['teacherId'];
            $correctGroup = Group::whereHas('schedules', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })->where('id', $this->groupId)->count();

            if ($correctGroup == 0) {
                session()->flash('error', 'Anda tidak memiliki akses ke kelas ini');
                $this->redirect('/teacher/payment', navigate: true);
            }

            $students = Student::orderBy('name')->where('group_id', $this->groupId)->get();
            $paymentType = PaymentType::find($this->paymentTypeId);
            if (!$paymentType) {
                session()->flash('error', "Tipe pembayaran tidak tersedia untuk kelas ini");
                $this->redirect('/teacher/payment', navigate: true);
            }

            $group = Group::find($this->groupId);
            if (!$group) {
                session()->flash('error', "Kelas tidak ditemukan");
                $this->redirect('/teacher/payment', navigate: true);
            }

            $gradeId = $group->grade_id;
            $gradeFee = DB::table('grade_fees')
                ->where('grade_id', $gradeId)
                ->where('payment_type_id', $this->paymentTypeId)
                ->first();
            if (!$gradeFee) {
                session()->flash('error', "Tipe tagihan pembayaran tidak tersedia untuk kelas ini");
                $this->redirect('/teacher/payment', navigate: true);
            }


            return view('livewire.teacher.payment.read.payment-student-read', [
                'students' => $students,
                'group' => $group,
                'paymentType' => $paymentType,
                'gradeFee' => $gradeFee,
            ]);
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            $this->redirect('/teacher/payment', navigate: true);
        }
    }

    public function detailPayment($studentId)
    {
        $params = [
            'studentId' => $studentId,
            'paymentTypeId' => $this->paymentTypeId,
        ];

        return redirect()->to('/teacher/payment/read/detail?' . http_build_query($params));
    }
}
