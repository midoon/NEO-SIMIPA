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
    #[Title('Admin Guru')]

    public $search;

    public $selected = [];
    public $selectAll = false;

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

    public function updatingSelectAll($value)
    {
        if ($value) {
            // Select all student IDs
            $this->selected = Teacher::pluck('id')->toArray();
        } else {
            // Unselect all
            $this->selected = [];
        }
    }

    public function deleteSelected()
    {

        if (count($this->selected) > 0) {
            try {
                Teacher::destroy($this->selected);
                $this->selected = [];
                $this->selectAll = false;
                session()->flash('success', 'Berhasil menghapus data guru.');
                return $this->redirect('/admin/teacher', navigate: true);
            } catch (Exception $e) {
                session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
            }
        } else {
            session()->flash('error', 'Tidak ada data yang dipilih untuk dihapus.');
            return $this->redirect('/admin/teacher', navigate: true);
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
}
