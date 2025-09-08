<?php

namespace App\Livewire\Teacher\Payment\Create;

use App\Models\Fee;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateForm extends Component
{
    public $showModal = false;

    public $date, $amount;

    public $bill;

    public $fee;

    public function mount()
    {
        $this->date = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {
        $bill = $this->bill ?? 0;


        return view('livewire.teacher.payment.create.create-form', [
            'bill' => $bill
        ]);
    }

    #[On('openCreateForm')]
    public function createForm($studentId, $paymentTypeId)
    {
        $this->amount = '';
        $this->showModal = true;
        $fee = Fee::where('payment_type_id', $paymentTypeId)->where('student_id', $studentId)->first();
        if (!$fee) {
            session()->flash('error', "Data tagihan tidak ditemukan");
            $this->showModal = false;
        }
        $this->fee = $fee;
        $this->bill = $fee->amount - $fee->paid_amount;
    }

    public function pay()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1|max:' . ($this->fee->amount - $this->fee->paid_amount),
            'date' => 'required|date'
        ]);
        dd($this->amount, $this->date);
    }
}
