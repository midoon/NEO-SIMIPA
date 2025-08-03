<?php

namespace App\Livewire\Admin\PaymentType;

use App\Models\PaymentType;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPaymentTypeList extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Tipe Pembayaran')]

    public $search;

    public $selected = [];
    public $selectAll = false;

    public function render()
    {
        try {
            $paymeentTYpeQuery = PaymentType::query();
            if ($this->search) {
                $paymeentTYpeQuery->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            }
            $paymentTypes = $paymeentTYpeQuery->orderBy('name')->paginate(12)->withQueryString();
            return view('livewire.admin.payment-type.admin-payment-type-list', ['paymentTypes' => $paymentTypes]);
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem kegiatan load data: ' . $e->getMessage());
            return $this->redirect('/admin/dashboard', navigate: true);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage(); // fungsi bawaan livewire
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // Select all student IDs
            $this->selected = PaymentType::pluck('id')->toArray();
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
            return $this->redirect('/admin/payment/type', navigate: true);
        }

        $this->dispatch('openModalDeleteMultipleEvent', selected: $this->selected);
    }
}
