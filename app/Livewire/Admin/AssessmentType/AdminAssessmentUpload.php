<?php

namespace App\Livewire\Admin\AssessmentType;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AdminAssessmentUpload extends Component
{

    use WithFileUploads;

    public $showModal = false;
    public $file;

    public function render()
    {
        return view('livewire.admin.assessment-type.admin-assessment-upload');
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
                "Content-Disposition" => "attachment; filename=assessment_type_template.csv"
            ];

            $columns = ['name', 'code'];

            $callback = function () use ($columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem download template assessment type: ' . $e->getMessage());
            return $this->redirect('/admin/activity', navigate: true);
        }
    }

    function batalUpload()
    {
        $this->reset('file');
        $this->showModal = false;
    }
}
