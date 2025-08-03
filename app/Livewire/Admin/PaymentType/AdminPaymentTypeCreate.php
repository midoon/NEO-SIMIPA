<?php

namespace App\Livewire\Admin\PaymentType;

use App\Models\PaymentType;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminPaymentTypeCreate extends Component
{
    public $showModal = false;
    public $name, $description = [];

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('livewire.admin.payment-type.admin-payment-type-create');
    }

    #[On('openModalCreateEvent')]
    public function createModal()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
    }

    public function store()
    {
        try {
            $this->validate();

            // Check if subject already exists
            $isPaymentTypeExist = PaymentType::where('name', $this->name)->first();
            if ($isPaymentTypeExist) {
                session()->flash('error', 'Tipe pembayaran sudah ada.');
                return $this->redirect('/admin/payment/type', navigate: true);
            }

            if ($this->description === "") {
                $this->description = $this->name;
            }

            PaymentType::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            session()->flash('success', 'Tipe pembayaran berhasil ditambahkan.');
            $this->showModal = false;
            $this->resetInputFields();
            return $this->redirect('/admin/payment/type', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem payment type store: ' . $e->getMessage());
            return $this->redirect('/admin/payment/type', navigate: true);
        }
    }
}
