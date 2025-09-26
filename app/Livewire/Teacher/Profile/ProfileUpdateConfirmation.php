<?php

namespace App\Livewire\Teacher\Profile;

use App\Models\Teacher;
use Livewire\Attributes\On;
use Livewire\Component;

class ProfileUpdateConfirmation extends Component
{
    public $nik, $name, $gender;
    public $showModal = false;
    public function render()
    {
        return view('livewire.teacher.profile.profile-update-confirmation');
    }

    #[On('updateConfirmation')]
    public function openModal($name, $nik, $gender)
    {
        $this->name = $name;
        $this->nik = $nik;
        $this->gender = $gender;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updateProfile()
    {
        try {
            $teacherId = session('teacher')['teacherId'];
            $teacher = Teacher::find($teacherId);

            // check duplicate nik
            $existingNik = Teacher::where('nik', $this->nik)->where('id', '!=', $teacherId)
                ->first();
            if ($existingNik) {
                $this->showModal = false;
                session()->flash('error', 'NIK sudah digunakan oleh guru : ' . $existingNik->name);
                return redirect(request()->header('Referer'));
            }

            $teacher->name = $this->name;
            $teacher->nik = $this->nik;
            $teacher->gender = $this->gender;
            $teacher->save();

            // refresh ke halaman atau url saat ini serta kirim pesan sukses
            $this->showModal = false;
            session()->flash('success', 'Berhasil memperbarui profil.');

            // Refresh ke URL saat ini
            return redirect(request()->header('Referer'));
        } catch (\Exception $e) {
            // refresh ke halaman atau url saat ini serta kirim pesan error
            $this->showModal = false;
            session()->flash('error', 'Gagal memperbarui profil. Silakan coba lagi.');
            return redirect(request()->header('Referer'));
        }
    }
}
