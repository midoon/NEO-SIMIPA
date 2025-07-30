<?php

namespace App\Livewire\Admin\Activity;

use App\Models\Activity;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminActivityCreate extends Component
{
    public $showModal = false;
    public $name, $description = [];

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('livewire.admin.activity.admin-activity-create');
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
            $isExistActivity = Activity::where('name', $this->name)->first();
            if ($isExistActivity) {
                session()->flash('error', 'Jenis kegiatan sudah terdaftar.');
                return $this->redirect('/admin/activity', navigate: true);
            }



            Activity::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);

            session()->flash('success', 'Kegiatan berhasil ditambahkan.');
            $this->showModal = false;
            $this->resetInputFields();
            return $this->redirect('/admin/activity', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem activity store: ' . $e->getMessage());
            return $this->redirect('/admin/activity', navigate: true);
        }
    }
}
