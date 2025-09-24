<?php

namespace App\Livewire\Teacher\Payment\Fee;

use App\Models\Fee;
use App\Models\Student;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class PaymentFeeDetail extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Payment')]

    #[Url()]
    public $studentId;

    public $student, $fees;

    public function mount()
    {
        try {
            $this->student = Student::find($this->studentId);
            if (!$this->student) {
                session()->flash('error', 'Siswa tidak ditemukan');
                return $this->redirect('/teacher/payment/fee', navigate: true);
            }

            $this->fees = Fee::where('student_id', $this->studentId)->get();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return $this->redirect('/teacher/payment/fee', navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.teacher.payment.fee.payment-fee-detail', [
            'student' => $this->student,
            'fees' => $this->fees
        ]);
    }
}
