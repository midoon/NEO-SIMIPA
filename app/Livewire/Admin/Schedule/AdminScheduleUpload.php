<?php

namespace App\Livewire\Admin\Schedule;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminScheduleUpload extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $file;

    public function render()
    {
        return view('livewire.admin.schedule.admin-schedule-upload');
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
                "Content-Disposition" => "attachment; filename=schedule_template.csv"
            ];

            $columns = ['group', 'subject', 'teacher', 'day', 'start_time', 'end_time'];

            $callback = function () use ($columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem download template schedule: ' . $e->getMessage());
            return $this->redirect('/admin/schedule', navigate: true);
        }
    }

    function batalUpload()
    {
        $this->reset('file');
        $this->showModal = false;
    }
}
