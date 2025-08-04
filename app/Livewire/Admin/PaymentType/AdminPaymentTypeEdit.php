<?php

namespace App\Livewire\Admin\PaymentType;

use App\Models\PaymentType;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminPaymentTypeEdit extends Component
{
    public $showModal = false;
    public $name;
    public $description;
    public $paymentTypeId;

    public function render()
    {
        return view('livewire.admin.payment-type.admin-payment-type-edit');
    }

    #[On('openModalEditEvent')]
    public function openModal($id)
    {
        $this->name = '';
        $this->description = '';
        $this->paymentTypeId = $id;
        $this->showModal = true;

        $pt = PaymentType::find($id);
        if ($pt) {
            $this->name = $pt->name;
            $this->description = $pt->description;
        } else {
            session()->flash('error', 'Tipe pembayaran tidak ditemukan.');
            return $this->redirect('/admin/payment/type', navigate: true);
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
            ]);

            // Check if grade already exists

            $isPtExist = PaymentType::where('name', $this->name)->first();
            if ($isPtExist && $isPtExist->id !== $this->paymentTypeId) {
                session()->flash('error', "Tipe pembayaran sudah ada");
                return $this->redirect('/admin/payment/type', navigate: true);
            }
            if ($this->description === "") {
                $this->description = $this->name;
            }




            $paymentType = PaymentType::find($this->paymentTypeId);
            if ($paymentType) {
                $paymentType->update(['name' => $this->name, 'description' => $this->description]);
                session()->flash('success', 'Tipe pembayaran berhasil diperbarui.');
            } else {
                session()->flash('error', 'Tipe pembayaran tidak ditemukan.');
            }

            $this->showModal = false;
            $this->name = '';
            $this->paymentTypeId = null;
            $this->description = '';
            return $this->redirect('/admin/payment/type', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem update: ' . $e->getMessage());
            return $this->redirect('/admin/payment/type', navigate: true);
        }
    }
}
