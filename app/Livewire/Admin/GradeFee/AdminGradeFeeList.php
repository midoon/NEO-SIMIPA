<?php

namespace App\Livewire\Admin\GradeFee;

use App\Models\GradeFee;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AdminGradeFeeList extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Tagihan Kelas')]

    public $search;

    #[Url()] // mengambil nilai dari query param dan ditaruh langsung ke $grade_id
    public $payment_type_id;

    public $selected = [];
    public $selectAll = false;

    public function render()
    {
        try {
            $gradeFeeQuery = GradeFee::query()
                ->leftJoin('payment_types', 'grade_fees.payment_type_id', '=', 'payment_types.id')
                ->leftJoin('grades', 'grade_fees.grade_id', '=', 'grades.id')
                ->select('grade_fees.*', 'payment_types.name as payment_type_name', 'grades.name as grade_name');

            if ($this->payment_type_id) {
                $gradeFeeQuery->where('grade_fees.payment_type_id', $this->payment_type_id);
            }

            if ($this->search) {
                $gradeFeeQuery->where(function ($q) {
                    $q->where('grades.name', 'like', '%' . $this->search . '%')
                        ->orWhere('payment_types.name', 'like', '%' . $this->search . '%');
                });
            }

            $gradeFees = $gradeFeeQuery
                ->orderBy('grades.name')
                ->orderBy('payment_types.name')
                ->paginate(20)
                ->withQueryString();
            return view('livewire.admin.grade-fee.admin-grade-fee-list', ['gradeFees' => $gradeFees]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem load data: ' . $e->getMessage());
            return $this->redirect('/admin/dashboard', navigate: true);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
        $this->reset('payment_type_id');
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // Select all student IDs
            $this->selected = GradeFee::pluck('id')->toArray();
        } else {
            // Unselect all
            $this->selected = [];
        }
    }

    public function triggerModalCreate()
    {
        $this->dispatch('openModalCreateEvent');
    }

    public function triggerModalEdit($id)
    {
        $this->dispatch('openModalEditEvent', id: $id);
    }

    public function triggerModalDelete($id)
    {
        $this->dispatch('openModalDeleteEvent', id: $id);
    }

    public function triggerModalUpload()
    {
        $this->dispatch('openModalUploadEvent');
    }

    public function triggerModalDeleteMultiple()
    {
        if (count($this->selected) === 0) {
            session()->flash('error', 'Tidak ada data yang dipilih untuk dihapus.');
            return $this->redirect('/admin/fee/grade', navigate: true);
        }

        $this->dispatch('openModalDeleteMultipleEvent', selected: $this->selected);
    }
}
