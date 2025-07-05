<?php

namespace App\Livewire\Admin\Teacher;

use Exception;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminTeacherUpload extends Component
{
    public $showModal = false;
    public function render()
    {
        return view('livewire.admin.teacher.admin-teacher-upload');
    }

    #[On('openModalUploadEvent')]
    public function mount()
    {
        $this->showModal = true;
    }

    public function downloadTemplate()
    {
        try {
            $headers = [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=teacher_template.csv"
            ];

            $columns = ['name', 'nik', 'gender',];

            $callback = function () use ($columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Exception $e) {
            session()->flash('error', 'Gagal download template: ' . $e->getMessage());
            return $this->redirect('/admin/dashboard', navigate: true);
        }
    }

    public function upload()
    {
        dd("upload");
    }
}
