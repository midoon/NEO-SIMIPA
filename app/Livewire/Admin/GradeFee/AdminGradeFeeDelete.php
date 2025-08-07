<?php

namespace App\Livewire\Admin\GradeFee;

use App\Models\Fee;
use App\Models\GradeFee;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGradeFeeDelete extends Component
{
    public $showModal = false;
    public $gradeFeeId;

    public function render()
    {
        return view('livewire.admin.grade-fee.admin-grade-fee-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->gradeFeeId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            $gradeFee = GradeFee::findOrFail($this->gradeFeeId);
            $groupsId = Group::where('grade_id', $gradeFee->grade_id)->pluck('id')->toArray();
            $students = Student::whereIn('group_id', $groupsId)->get();

            DB::transaction(function () use ($gradeFee, $students) {

                foreach ($students as $s) {
                    $fee = Fee::where('student_id', $s->id)->where('grade_fee_id', $gradeFee->id)->first();
                    $fee->delete();
                }

                // Delete the grade fee
                $gradeFee->delete();
            });

            session()->flash('success', 'Data tagihan kelas berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/fee/grade', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/fee/grade', navigate: true);
        }
    }
}
