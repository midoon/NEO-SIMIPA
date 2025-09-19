<?php

namespace App\Livewire\Teacher\Payment\Delete;

use Livewire\Attributes\On;
use Livewire\Component;

class DeleteConfirmationForm extends Component
{
    public $showModal = false;
    public $paymentId;

    public function render()
    {
        return view('livewire.teacher.payment.delete.delete-confirmation-form');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->paymentId = $id;
        $this->showModal = true;
    }

    public function cancel()
    {
        $this->paymentId = "";
        $this->showModal = false;
    }

    public function delete()
    {
        dd($this->paymentId);
    }
}
