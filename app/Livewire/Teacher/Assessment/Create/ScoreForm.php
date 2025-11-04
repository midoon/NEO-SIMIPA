<?php

namespace App\Livewire\Teacher\Assessment\Create;

use App\Models\AssessmentScore;
use Livewire\Attributes\On;
use Livewire\Component;

class ScoreForm extends Component
{
    public $showModal = false;
    public $score;

    public $studentId, $assessmentTypeId;
    public function render()
    {
        return view('livewire.teacher.assessment.create.score-form');
    }

    #[On('openModalInputScore')]
    public function createForm($studentId, $assessmentTypeId)
    {
        $this->studentId = $studentId;
        $this->assessmentTypeId = $assessmentTypeId;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'score' => 'required|numeric|min:0|max:100',
        ]);

        $isEsistingScore = AssessmentScore::where('student_id', $this->studentId)
            ->where('assessment_type_id', $this->assessmentTypeId)
            ->count();
        if ($isEsistingScore) {
            $this->showModal = false;
            session()->flash('error', 'Pembayaran berhasil disimpan.');
            return redirect(request()->header('Referer'));
        }

        AssessmentScore::create([
            'student_id' => $this->studentId,
            'assessment_type_id' => $this->assessmentTypeId,
            'score' => $this->score,
        ]);



        $this->showModal = false;
        session()->flash('success', 'Score saved successfully.');
        return redirect(request()->header('Referer'));
    }
}
