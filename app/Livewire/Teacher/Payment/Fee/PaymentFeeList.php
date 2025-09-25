<?php

namespace App\Livewire\Teacher\Payment\Fee;

use App\Models\Group;
use App\Models\Student;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

class PaymentFeeList extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Payment')]

    #[Url()]
    public $groupId;

    public $students, $group;

    public function mount()
    {
        try {
            // pengecekkan akses
            $teacherId = session('teacher')['teacherId'];
            $correctGroup = Group::whereHas('schedules', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            })->where('id', $this->groupId)->count();

            if ($correctGroup == 0) {
                session()->flash('error', 'Anda tidak memiliki akses ke kelas ini');
                return $this->redirect('/teacher/payment', navigate: true);
            }

            $this->students = Student::orderBy('name')->where('group_id', $this->groupId)->get();
            $this->group = Group::find($this->groupId);
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return $this->redirect('/teacher/payment', navigate: true);
        }
    }

    public function render()
    {

        return view('livewire.teacher.payment.fee.payment-fee-list', ['students' => $this->students, 'group' => $this->group]);
    }

    public function detailFee($studentId)
    {
        $params = [
            'studentId' => $studentId,


        ];

        return $this->redirect('/teacher/payment/fee/detail?' . http_build_query($params), navigate: true);
    }
}
