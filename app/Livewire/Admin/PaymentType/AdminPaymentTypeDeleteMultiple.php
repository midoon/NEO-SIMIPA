<?php

namespace App\Livewire\Admin\PaymentType;

use App\Models\PaymentType;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminPaymentTypeDeleteMultiple extends Component
{
    public $showModal = false;
    public $selected = [];

    public function render()
    {
        return view('livewire.admin.payment-type.admin-payment-type-delete-multiple', ['selectedCount' => count($this->selected)]);
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
            PaymentType::destroy($this->selected);
            $this->selected = [];
            session()->flash('success', 'Berhasil menghapus data tipe kegiatan.');
            return $this->redirect('/admin/payment/type', navigate: true);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
            return $this->redirect('/admin/payment/type', navigate: true);
        }
    }
}
