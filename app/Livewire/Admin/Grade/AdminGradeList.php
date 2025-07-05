<?php

namespace App\Livewire\Admin\Grade;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class AdminGradeList extends Component
{
    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Kelas')]

    public $search;

    public function render()
    {
        return view('livewire.admin.grade.admin-grade-list');
    }
}
