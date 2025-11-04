<?php

namespace App\Livewire\Teacher\Assessment;

use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherAssessmentMenu extends Component
{

    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Assessment')]

    public $todayDate;
    public $todayDay;

    public function mount()
    {
        $this->todayDate = Carbon::now()->format('d-m-Y'); // contoh: 17-08-2025
        $this->todayDay  = Carbon::now()->translatedFormat('l'); // contoh: Minggu
    }

    public function render()
    {
        return view('livewire.teacher.assessment.teacher-assessment-menu');
    }

    public function triggerFilterCreate()
    {
        $this->dispatch('openFilterCreate');
    }

    public function triggerFilterRead()
    {
        $this->dispatch('openFilterRead');
    }

    public function triggerFilterReport()
    {
        $this->dispatch('openFilterReport');
    }
}
