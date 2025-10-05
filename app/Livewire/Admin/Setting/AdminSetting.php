<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AdminSetting extends Component
{
    #[Layout('components.layouts.admin')]
    #[Title('Admin Setting')]

    public function render()
    {
        return view('livewire.admin.setting.admin-setting');
    }
}
