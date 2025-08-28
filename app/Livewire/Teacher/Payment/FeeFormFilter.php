<?php

namespace App\Livewire\Teacher\Payment;

use App\Models\Group;
use Livewire\Attributes\On;
use Livewire\Component;

class FeeFormFilter extends Component
{
    public $showModal = false;

    public $groupId;

    public function render()
    {
        $teacherId = session('teacher')['teacherId'];
        $groups =  Group::whereHas('schedules', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->orderBy('name')->get();
        return view('livewire.teacher.payment.fee-form-filter', ['groups' => $groups]);
    }

    #[On('openFilterFee')]
    public function feeModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->groupId = '';
    }

    public function readFee()
    {
        // validasi
        $this->validate([
            'groupId' => 'required',

        ]);

        $params = [
            'groupId' => $this->groupId,


        ];

        return redirect()->to('/teacher/fee/read?' . http_build_query($params));
    }
}
