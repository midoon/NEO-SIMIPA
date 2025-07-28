<?php

namespace App\Livewire\Admin\Subject;

use App\Models\Subject;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminSubjectEdit extends Component
{
    public $showModal = false;
    public $name;
    public $code;
    public $subjectId;

    public function render()
    {
        return view('livewire.admin.subject.admin-subject-edit');
    }

    #[On('openModalEditEvent')]
    public function openModal($id)
    {
        $this->name = '';
        $this->code = '';
        $this->subjectId = $id;
        $this->showModal = true;

        $subject = Subject::find($id);
        if ($subject) {
            $this->name = $subject->name;
            $this->code = $subject->code;
        } else {
            session()->flash('error', 'Mata pelajaran tidak ditemukan.');
            return $this->redirect('/admin/subject', navigate: true);
        }
    }

    public function update()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
            ]);

            // Check if grade already exists
            if (Subject::where('code', $this->code)->exists() && Subject::where('code', $this->code)->first()->id !== $this->subjectId) {
                session()->flash('error', "Kode mata pelajaran sudah terdaftar.");
                return $this->redirect('/admin/subject', navigate: true);
            }
            if (Subject::where('name', $this->name)->exists() && Subject::where('name', $this->name)->first()->id !== $this->subjectId) {
                session()->flash('error', "Mata pelajaran sudah terdaftar.");
                return $this->redirect('/admin/subject', navigate: true);
            }




            $subject = Subject::find($this->subjectId);
            if ($subject) {
                $subject->update(['name' => $this->name, 'code' => $this->code]);
                session()->flash('success', 'Mata pelajaran berhasil diperbarui.');
            } else {
                session()->flash('error', 'Mata pelajaran tidak ditemukan.');
            }

            $this->showModal = false;
            $this->name = '';
            $this->subjectId = null;
            $this->code = '';
            return $this->redirect('/admin/subject', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error sistem update: ' . $e->getMessage());
            return $this->redirect('/admin/subject', navigate: true);
        }
    }
}
