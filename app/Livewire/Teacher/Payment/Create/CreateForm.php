<?php

namespace App\Livewire\Teacher\Payment\Create;

use App\Models\Fee;
use App\Models\Payment;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $this->bill = "";
        $this->fee = null;
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

        DB::transaction(function () {
            // update  in fees table
            $this->fee->paid_amount += $this->amount;

            $status = 'unpaid';

            if ($this->fee->paid_amount == $this->fee->amount) {
                $status = 'paid';
            } elseif ($this->fee->paid_amount < $this->fee->amount && $this->fee->paid_amount > 0) {
                $status = 'partial';
            }
            $this->fee->status = $status;
            $this->fee->save();

            //insert to payments table
            Payment::create([
                'fee_id' => $this->fee->id,
                'student_id' => $this->fee->student_id,
                'amount' => $this->amount,
                'payment_date' => $this->date,
                "description" => "Pembayaran secara manual oleh guru"
            ]);

            // if status = paid, create receipt
            if ($status == 'paid') {
                $receiptNumber = 'MIPA-' . now()->format('YmdHis');
                Receipt::create([
                    'fee_id' => $this->fee->id,
                    'receipt_number' => $receiptNumber,
                ]);
            }
        });


        $this->showModal = false;
        // perlu imlementasi refresh parent component
        session()->flash('success', 'Pembayaran berhasil disimpan.');

        // Refresh ke URL saat ini
        return redirect(request()->header('Referer'));
    }
}
