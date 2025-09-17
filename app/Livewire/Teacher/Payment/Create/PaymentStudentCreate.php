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

    public $group, $paymentType, $gradeFee;

    protected $rules = [
        'groupId' => 'required',
        'paymentTypeId' => 'required',
    ];

    protected $listeners = ['refreshParent' => '$refresh'];

    public function mount()
    {
        $this->validate();

        $group = Group::find($this->groupId);
        if (!$group) {
            session()->flash('error', "Kelas tidak ditemukan");
            return $this->redirect('/teacher/payment', navigate: true);
        }

        $paymentType = PaymentType::find($this->paymentTypeId);
        if (!$paymentType) {
            session()->flash('error', "Tipe pembayaran tidak tersedia untuk kelas ini");
            return $this->redirect('/teacher/payment', navigate: true);
        }

        $gradeFee = DB::table('grade_fees')
            ->where('grade_id', $group->grade_id)
            ->where('payment_type_id', $this->paymentTypeId)
            ->first();

        if (!$gradeFee) {
            session()->flash('error', 'Tagihan pembayaran tidak ditemukan');
            return $this->redirect('/teacher/payment', navigate: true);
        }

        // simpan properti supaya render() bisa pakai
        $this->group    = $group;
        $this->paymentType = $paymentType;
        $this->gradeFee = $gradeFee;
    }

    public function render()
    {
        $students = DB::table('students')
            ->join('groups', 'students.group_id', '=', 'groups.id')
            ->where('students.group_id', $this->groupId)
            ->select('students.*', 'groups.name as group_name')
            ->orderBy('students.name')->get();

        return view('livewire.teacher.payment.create.payment-student-create', [
            'students' => $students,
            'group' => $this->group,
            'paymentType' => $this->paymentType,
            'gradeFee' => $this->gradeFee,
        ]);
    }

    public function showModalPayment($studentId)
    {
        $this->dispatch('openCreateForm', studentId: $studentId, paymentTypeId: $this->paymentTypeId);
    }
}
