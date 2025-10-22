<?php

namespace App\Livewire\Admin\PaymentType;

use App\Models\PaymentType;
use Illuminate\Support\Facades\DB;
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
            $existData = [];
            if (DB::table('fees')->where('payment_type_id', $this->paymentTypeId)->exists()) {
                array_push($existData, 'tagihan');
            }



            if (count($existData) != 0) {
                $this->dispatch('confirmDelete', [
                    'message' => "Data tipe pembayaran yang ingin anda hapus masih digunakan di data " . implode(", ", $existData)
                ]);
                return;
            }

            PaymentType::findOrFail($this->paymentTypeId)->delete();
            session()->flash('success', 'Data tipe pembayaran berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/payment/type', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/payment/type', navigate: true);
        }
    }

    #[On('forceDelete')]
    public function forceDelete()
    {
        PaymentType::findOrFail($this->paymentTypeId)->delete();
        session()->flash('success', 'Data tipe pembayaran berhasil dihapus.');
        $this->showModal = false;
        return $this->redirect('/admin/payment/type', navigate: true);
    }
}
