<?php

namespace App\Livewire\Admin\Student;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminStudentDelete extends Component
{
    public $showModal = false;
    public $studentId;

    public function render()
    {
        return view('livewire.admin.student.admin-student-delete');
    }

    #[On('openModalDeleteEvent')]
    public function openModal($id)
    {
        $this->studentId = $id;
        $this->showModal = true;
    }

    public function delete()
    {
        try {
            $existData = [];
            if (DB::table('fees')->where('student_id', $this->studentId)->exists()) {
                array_push($existData, 'tagihan');
            }
            if (DB::table('payments')->where('student_id', $this->studentId)->exists()) {
                array_push($existData, 'pembayaran');
            }


            if (count($existData) != 0) {
                $this->dispatch('confirmDelete', [
                    'message' => "Data siswa yang ingin anda hapus masih digunakan di data " . implode(", ", $existData)
                ]);
                return;
            }

            Student::findOrFail($this->studentId)->delete();
            session()->flash('success', 'Data rombel berhasil dihapus.');
            $this->showModal = false;
            return $this->redirect('/admin/student', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem delete: ' . $e->getMessage());
            return $this->redirect('/admin/student', navigate: true);
        }
    }

    #[On('forceDelete')]
    public function forceDelete()
    {
        Student::findOrFail($this->studentId)->delete();
        session()->flash('success', 'Data siswa berhasil dihapus.');
        $this->showModal = false;
        return $this->redirect('/admin/student', navigate: true);
    }
}
