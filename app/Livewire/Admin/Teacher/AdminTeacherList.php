<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AdminTeacherList extends Component
{
    #[Layout('components.layouts.admin')]
    #[Title('Admin Dashboard')]
    public function render()
    {
        try {
            $query = request()->query();
            $teacherQuery = Teacher::query();
            $teacherQuery->when(isset($query['name']), function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query['name'] . '%');
            });
            $teacherQuery->when(isset($query['nik']), function ($q) use ($query) {
                $q->where('nik', 'like', '%' . $query['nik'] . '%');
            });

            $teachers = $teacherQuery->orderBy('name')->paginate(10)->withQueryString();
            return view('livewire.admin.teacher.admin-teacher-list', ['teachers' => $teachers]);
        } catch (Exception $e) {
        }
    }
}
