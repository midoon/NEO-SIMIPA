<?php

namespace App\Livewire\Admin\Activity;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminActivityUpload extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $file;

    public function render()
    {
        return view('livewire.admin.activity.admin-activity-upload');
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
                "Content-Disposition" => "attachment; filename=activity_template.csv"
            ];

            $columns = ['name', 'description'];

            $callback = function () use ($columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem download template activity: ' . $e->getMessage());
            return $this->redirect('/admin/activity', navigate: true);
        }
    }

    function batalUpload()
    {
        $this->reset('file');
        $this->showModal = false;
    }
}
