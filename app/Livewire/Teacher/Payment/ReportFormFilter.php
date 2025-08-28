<?php

namespace App\Livewire\Teacher\Payment;

use App\Models\Group;
use App\Models\PaymentType;
use Livewire\Attributes\On;
use Livewire\Component;

class ReportFormFilter extends Component
{
    public $showModal = false;

    public $groupId, $paymentTypeId = [];
    public function render()
    {
        $teacherId = session('teacher')['teacherId'];
        $groups =  Group::whereHas('schedules', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('name')->get();
        $paymentTypes = PaymentType::orderBy('name')->get();
        return view('livewire.teacher.payment.report-form-filter',  ['groups' => $groups, 'paymentTypes' => $paymentTypes]);
    }

    #[On('openFilterReport')]
    public function reportModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->groupId = '';
        $this->paymentTypeId = '';
    }

    public function report()
    {
        // validasi
        $this->validate([
            'groupId' => 'required',
            'paymentTypeId' => 'required',
        ]);

        $params = [
            'groupId' => $this->groupId,
            'paymentTypeId' => $this->paymentTypeId,

        ];

        return redirect()->to('/teacher/payment/report?' . http_build_query($params));
    }
}
