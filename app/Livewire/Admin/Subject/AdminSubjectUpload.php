<?php

namespace App\Livewire\Admin\Subject;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminSubjectUpload extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $file;


    public function render()
    {
        return view('livewire.admin.subject.admin-subject-upload');
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
                "Content-Disposition" => "attachment; filename=subject_template.csv"
            ];

            $columns = ['name', 'code'];

            $callback = function () use ($columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem download template subject: ' . $e->getMessage());
            return $this->redirect('/admin/subject', navigate: true);
        }
    }

    function batalUpload()
    {
        $this->reset('file');
        $this->showModal = false;
    }
}
