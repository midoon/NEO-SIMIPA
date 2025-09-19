<?php

namespace App\Livewire\Teacher\Payment\Delete;

use App\Models\Fee;
use App\Models\Payment;
use App\Models\Receipt;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteConfirmationForm extends Component
{
    public $showModal = false;
    public $paymentId;

    public function render()
    {
        return view('livewire.teacher.payment.delete.delete-confirmation-form');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->paymentId = $id;
        $this->showModal = true;
    }

    public function cancel()
    {
        $this->paymentId = "";
        $this->showModal = false;
    }

    public function delete()
    {
        try {
            $payment = Payment::find($this->paymentId);
            $fee = Fee::find($payment->fee_id);

            DB::transaction(function () use ($payment, $fee) {
                $status = 'partial';
                if ($fee->paid_amount - $payment->amount == 0) {
                    $status = 'unpaid';
                }

                $fee->status = $status;
                $fee->paid_amount = $fee->paid_amount - $payment->amount;
                $fee->save();

                $payment->delete();

                // delete reciept
                Receipt::where("fee_id", $fee->id)->delete();
            });

            $this->showModal = false;
            session()->flash('success', 'Pembayaran berhasil dihapus.');

            // Refresh ke URL saat ini
            return redirect(request()->header('Referer'));
        } catch (Exception $e) {
            session()->flash('error', 'gagal menghapus pembayaran');

            // Refresh ke URL saat ini
            return redirect(request()->header('Referer'));
        }
    }
}
