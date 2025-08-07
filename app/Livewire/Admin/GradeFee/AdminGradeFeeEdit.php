<?php

namespace App\Livewire\Admin\GradeFee;

use App\Models\Fee;
use App\Models\GradeFee;
use App\Models\PaymentType;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGradeFeeEdit extends Component
{
    public $showModal = false;
    public $paymentTypeId, $amount, $dueDate, $gradeFeeId;

    public function render()
    {
        $paymentTypes = PaymentType::orderBy('name')->get();
        return view('livewire.admin.grade-fee.admin-grade-fee-edit', [
            'paymentTypes' => $paymentTypes,
        ]);
    }

    #[On('openModalEditEvent')]
    public function openModal($id)
    {

        $this->gradeFeeId = $id;
        $this->showModal = true;

        // Load the grade data by ID
        $gradeFee = GradeFee::find($id);
        if ($gradeFee) {
            $this->paymentTypeId = $gradeFee->payment_type_id;
            $this->amount = $gradeFee->amount;
            $this->dueDate = $gradeFee->due_date;
        } else {
            session()->flash('error', 'Tagihan kelas tidak ditemukan');
            return $this->redirect('/admin/fee/grade', navigate: true);
        }
    }

    private function resetInputFields()
    {
        $this->paymentTypeId = '';
        $this->amount = '';
        $this->dueDate = '';
    }

    public function update()
    {
        try {
            $this->validate([
                'paymentTypeId' => 'required|exists:payment_types,id',
                'amount' => 'required|numeric|min:0',
                'dueDate' => 'required|date|after_or_equal:today',
            ]);

            $gradeFee = GradeFee::find($this->gradeFeeId);

            $isGradeFeeExists = GradeFee::where('grade_id', $gradeFee->grade_id)
                ->where('payment_type_id', $this->paymentTypeId)
                ->first();
            if ($isGradeFeeExists->id != $this->gradeFeeId) {
                session()->flash('error', 'Tagihan kelas sudah ada.');
                return $this->redirect('/admin/fee/grade', navigate: true);
            }




            if (!$gradeFee) {
                session()->flash('error', 'Tagihan kelas tidak ditemukan');
                return $this->redirect('/admin/fee/grade', navigate: true);
            }

            DB::transaction(function () use ($gradeFee) {
                $gradeFee->update([
                    'payment_type_id' => $this->paymentTypeId,
                    'amount' => $this->amount,
                    'due_date' => $this->dueDate,
                ]);

                $fee = Fee::where('grade_fee_id', $this->gradeFeeId)->get();

                foreach ($fee as $f) {
                    $f->update([
                        'payment_type_id' => $this->paymentTypeId,
                        'amount' => $this->amount,
                        'due_date' => $this->dueDate,
                    ]);
                }
            });

            session()->flash('success', 'Tagihan kelas berhasil diubah.');
            $this->showModal = false;
            $this->resetInputFields();
            return $this->redirect('/admin/fee/grade', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem update: ' . $e->getMessage());
            return $this->redirect('/admin/fee/grade', navigate: true);
        }
    }
}
