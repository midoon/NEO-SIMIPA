<?php

namespace App\Livewire\Admin\Student;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminStudentUpload extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $file;

    public function render()
    {
        return view('livewire.admin.student.admin-student-upload');
    }

    #[On('openModalUploadEvent')]
    public function openModal()
    {
        $this->showModal = true;
    }

    public function downloadTemplate()
    {
        try {
            $headers = [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=student_template.csv"
            ];

            $columns = ['name', 'nisn', 'gender', 'group'];

            $callback = function () use ($columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem download template student: ' . $e->getMessage());
            return $this->redirect('/admin/student', navigate: true);
        }
    }

    function batalUpload()
    {
        $this->reset('file');
        $this->showModal = false;
    }
}
