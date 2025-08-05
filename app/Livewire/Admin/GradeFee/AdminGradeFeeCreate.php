<?php

namespace App\Livewire\Admin\GradeFee;

use App\Models\Fee;
use App\Models\Grade;
use App\Models\GradeFee;
use App\Models\PaymentType;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGradeFeeCreate extends Component
{
    public $showModal = false;
    public $paymentTypeId, $gradeId, $amount, $dueDate;

    public function render()
    {

        $paymentTypes = PaymentType::orderBy('name')->get();
        $grades = Grade::orderBy('name')->get();
        return view('livewire.admin.grade-fee.admin-grade-fee-create', [
            'paymentTypes' => $paymentTypes,
            'grades' => $grades,
        ]);
    }

    #[On('openModalCreateEvent')]
    public function createModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->paymentTypeId = '';
        $this->gradeId = '';
        $this->amount = '';
        $this->dueDate = '';
    }

    public function store()
    {
        try {


            $this->validate([
                'paymentTypeId' => 'required|exists:payment_types,id',
                'gradeId' => 'required|exists:grades,id',
                'amount' => 'required|numeric|min:0',
                'dueDate' => 'required|date|after_or_equal:today',
            ]);

            $isGradeFeeExists = GradeFee::where('grade_id', $this->gradeId)
                ->where('payment_type_id', $this->paymentTypeId)
                ->exists();
            if ($isGradeFeeExists) {
                session()->flash('error', 'Tagihan kelas sudah ada.');
                return $this->redirect('/admin/fee/grade', navigate: true);
            }



            DB::transaction(function () {
                GradeFee::create([
                    'payment_type_id' => $this->paymentTypeId,
                    'grade_id' => $this->gradeId,
                    'amount' => $this->amount,
                    'due_date' => $this->dueDate,
                ]);

                $students = Student::whereHas('group.grade', function ($q) {
                    $q->where('id', $this->gradeId);
                })->get();

                foreach ($students as $s) {
                    Fee::create([
                        'payment_type_id' => $this->paymentTypeId,
                        'student_id' => $s->id,
                        'amount' => $this->amount,
                        'due_date' => $this->dueDate,
                        'status' => 'unpaid',
                        'paid_amount' => 0,
                    ]);
                }
            });

            session()->flash('success', 'Tagihan kelas berhasil ditambahkan.');
            $this->showModal = false;
            $this->resetInputFields();
            return $this->redirect('/admin/fee/grade', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem schedule store: ' . $e->getMessage());
            return $this->redirect('/admin/fee/grade', navigate: true);
        }
    }
}
