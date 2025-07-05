<?php

namespace App\Livewire\Admin\Teacher;

use App\Models\Teacher;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class AdminTeacherList extends Component
{

    use WithPagination;

    #[Layout('components.layouts.admin')]
    #[Title('Admin Dashboard')]

    public $search;
    protected $listeners = ['teacherCreated' => 'refreshTeachers'];

    public function render()
    {
        try {
            $teacherQuery = Teacher::query()->select('id', 'name', 'nik', 'gender', 'role', 'account');;
            if ($this->search) {
                $teacherQuery->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->search . '%');
                });
            }
            $teachers = $teacherQuery->orderBy('name')->paginate(12)->withQueryString();
            $teachers->getCollection()->transform(function ($teacher) {
                return $teacher->makeHidden('password');
            });
            return view('livewire.admin.teacher.admin-teacher-list', ['teachers' => $teachers]);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
            return $this->redirect('/admin/dashboard', navigate: true);
        }
    }

    // untuk mengatur ulang halaman ketika pencarian berubah {bug pencarian tidak mengatur ulang halaman}
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function refreshTeachers()
    {
        $this->resetPage();
        $this->dispatch('refreshTeachers');
    }

    public function triggerModalEdit($id)
    {
        $this->dispatch('openModalEditEvent', id: $id);
    }

    public function triggerModalDelete($id)
    {
        $this->dispatch('openModalDeleteEvent', id: $id);
    }
}
