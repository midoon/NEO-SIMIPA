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

    public $group, $students, $paymentType, $gradeFee;

    protected $rules = [
        'groupId' => 'required',
        'paymentTypeId' => 'required',
    ];

    public function mount()
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
                return $this->redirect('/teacher/payment', navigate: true);
            }

            $this->students = Student::orderBy('name')->where('group_id', $this->groupId)->get();
            $this->paymentType = PaymentType::find($this->paymentTypeId);
            if (!$this->paymentType) {
                session()->flash('error', "Tipe pembayaran tidak tersedia untuk kelas ini");
                return $this->redirect('/teacher/payment', navigate: true);
            }

            $this->group = Group::find($this->groupId);
            if (!$this->group) {
                session()->flash('error', "Kelas tidak ditemukan");
                return $this->redirect('/teacher/payment', navigate: true);
            }

            $gradeId = $this->group->grade_id;
            $this->gradeFee = DB::table('grade_fees')
                ->where('grade_id', $gradeId)
                ->where('payment_type_id', $this->paymentTypeId)
                ->first();
            if (!$this->gradeFee) {
                session()->flash('error', "Tipe tagihan pembayaran tidak tersedia untuk kelas ini");
                return $this->redirect('/teacher/payment', navigate: true);
            }
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return $this->redirect('/teacher/payment', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.teacher.payment.read.payment-student-read', [
            'students' => $this->students,
            'group' => $this->group,
            'paymentType' => $this->paymentType,
            'gradeFee' => $this->gradeFee,
        ]);
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
