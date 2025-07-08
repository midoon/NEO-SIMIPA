<?php

namespace App\Livewire\Admin\Group;

use Exception;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminGroupUpload extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $file;

    public function render()
    {
        return view('livewire.admin.group.admin-group-upload');
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
                "Content-Disposition" => "attachment; filename=group_template.csv"
            ];

            $columns = ['name', 'grade'];

            $callback = function () use ($columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Exception $e) {
            session()->flash('error', 'Error sistem download template grade: ' . $e->getMessage());
            return $this->redirect('/admin/group', navigate: true);
        }
    }

    function batalUpload()
    {
        $this->reset('file');
        $this->showModal = false;
    }
}
