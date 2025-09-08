<?php

namespace App\Livewire\Teacher\Payment\Create;

use App\Models\Group;
use App\Models\PaymentType;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class PaymentStudentCreate extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Payment')]

    #[Url()] // mengambil nilai dari query param dan ditaruh langsung ke $grade_id
    public $groupId, $paymentTypeId;

    protected $rules = [
        'groupId' => 'required',
        'paymentTypeId' => 'required',
    ];

    protected $listeners = ['refreshParent' => '$refresh'];

    public function render()
    {
        try {
            $this->validate();
            $group = Group::find($this->groupId);
            if (!$group) {
                session()->flash('error', "Kelas tidak ditemukan");
                $this->redirect('/teacher/payment', navigate: true);
            }

            $paymentType = PaymentType::find($this->paymentTypeId);
            if (!$paymentType) {
                session()->flash('error', "Tipe pembayaran tidak tersedia untuk kelas ini");
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
            $students = DB::table('students')
                ->join('groups', 'students.group_id', '=', 'groups.id')
                ->where('students.group_id', $this->groupId)
                ->select('students.*', 'groups.name as group_name')
                ->orderBy('students.name')->get();




            return view('livewire.teacher.payment.create.payment-student-create', [
                'students' => $students,
                'group' => $group,
                'paymentType' => $paymentType,
                'gradeFee' => $gradeFee,
            ]);
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem payment: ' . $e->getMessage());
            $this->redirect('/teacher/payment', navigate: true);
        }
    }

    public function showModalPayment($studentId)
    {
        $this->dispatch('openCreateForm', studentId: $studentId, paymentTypeId: $this->paymentTypeId);
    }
}
