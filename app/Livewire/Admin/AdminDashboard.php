<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AdminDashboard extends Component
{
    #[Layout('components.layouts.admin')]
    #[Title('Admin Dashboard')]
    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}
