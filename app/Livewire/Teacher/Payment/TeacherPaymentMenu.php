<?php

namespace App\Livewire\Teacher\Payment;

use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherPaymentMenu extends Component
{
    #[Layout('components.layouts.teacher')]
    #[Title('Teacher Payment')]

    public $todayDate;
    public $todayDay;

    public $isBendahara = false;

    public function mount()
    {
        if (collect(session('teacher')['role'])->contains('bendahara')) {
            $this->isBendahara = true;
        }

        $this->todayDate = Carbon::now()->format('d-m-Y'); // contoh: 17-08-2025
        $this->todayDay  = Carbon::now()->translatedFormat('l'); // contoh: Minggu
    }

    public function render()
    {
        return view('livewire.teacher.payment.teacher-payment-menu');
    }

    public function triggerFilterCreate()
    {
        $this->dispatch('openFilterCreate');
    }

    public function triggerFilterRead()
    {
        $this->dispatch('openFilterRead');
    }

    public function triggerFilterFee()
    {
        $this->dispatch('openFilterFee');
    }

    public function triggerFilterReport()
    {
        $this->dispatch('openFilterReport');
    }
}
