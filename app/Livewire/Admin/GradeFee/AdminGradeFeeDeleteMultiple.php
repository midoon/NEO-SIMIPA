<?php

namespace App\Livewire\Admin\GradeFee;

use App\Models\Fee;
use App\Models\GradeFee;
use App\Models\Group;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminGradeFeeDeleteMultiple extends Component
{
    public $showModal = false;
    public $selected = [];

    public function render()
    {
        return view('livewire.admin.grade-fee.admin-grade-fee-delete-multiple', ['selectedCount' => count($this->selected),]);
    }

    #[On('openModalDeleteMultipleEvent')]
    public function openModal($selected)
    {
        $this->selected = $selected;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selected = [];
    }

    public function deleteSelected()
    {
        try {


            foreach ($this->selected as $gradeFeeId) {
                $gradeFee = GradeFee::findOrFail($gradeFeeId);
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
            }

            $this->selected = [];
            session()->flash('success', 'Berhasil menghapus data tagihan kelas.');
            return $this->redirect('/admin/fee/grade', navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
            return $this->redirect('/admin/fee/grade', navigate: true);
        }
    }
}
