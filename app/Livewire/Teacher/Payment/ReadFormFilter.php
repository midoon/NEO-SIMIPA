<?php

namespace App\Livewire\Teacher\Payment;

use App\Models\Group;
use App\Models\PaymentType;
use Livewire\Attributes\On;
use Livewire\Component;

class ReadFormFilter extends Component
{

    public $showModal = false;

    public $groupId, $paymentTypeId = [];

    public function render()
    {

        $teacherId = session('teacher')['teacherId'];

        $groups =  Group::whereHas('schedules', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('name')->get();

        if (collect(session('teacher')['role'])->contains('bendahara')) {
            $groups = Group::orderBy('name')->get();
        }


        $paymentTypes = PaymentType::orderBy('name')->get();

        return view('livewire.teacher.payment.read-form-filter', ['groups' => $groups, 'paymentTypes' => $paymentTypes]);
    }

    #[On('openFilterRead')]
    public function readModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->groupId = '';
        $this->paymentTypeId = '';
    }

    public function read()
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

        return redirect()->to('/teacher/payment/read?' . http_build_query($params));
    }
}
