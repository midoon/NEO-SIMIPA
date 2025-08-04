<?php

namespace App\Livewire\Admin\PaymentType;

use App\Models\PaymentType;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminPaymentTypeDelete extends Component
{
    public $showModal = false;
    public $paymentTypeId;

    public function render()
    {
        return view('livewire.admin.payment-type.admin-payment-type-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->paymentTypeId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            PaymentType::findOrFail($this->paymentTypeId)->delete();
            session()->flash('success', 'Data tipe pembayaran berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/payment/type', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/payment/type', navigate: true);
        }
    }
}
