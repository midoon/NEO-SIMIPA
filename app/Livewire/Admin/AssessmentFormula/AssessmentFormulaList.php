<?php

namespace App\Livewire\Admin\AssessmentFormula;

use App\Models\AssessmentFormula;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class AssessmentFormulaList extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Formula Penilaian')]

    public $search;

    public $selected = [];
    public $selectAll = false;

    public function render()
    {
        try {
            $assessmentFormulaQuery = AssessmentFormula::query();
            if ($this->search) {
                $assessmentFormulaQuery->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            }
            $assessmentFormula = $assessmentFormulaQuery
                ->orderBy('name')
                ->paginate(20)
                ->withQueryString();
            return view('livewire.admin.assessment-formula.assessment-formula-list', [
                'assessmentFormula' => $assessmentFormula,
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem kegiatan load data: ' . $e->getMessage());
            return $this->redirect('/admin/dashboard', navigate: true);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage(); // fungsi bawaan livewire
    }
}
