<?php

namespace App\Livewire\Auth;

use App\Models\Teacher;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherRegister extends Component
{
    #[Layout('components.layouts.auth')]
    #[Title('Teacher Register')]

    public $nik = "";
    public $password = "";
    public $confirm_password = "";

    protected $rules = [
        'nik' => 'required|numeric',
        'password' => 'required|min:8',
        'confirm_password' => 'required|min:8',
    ];
    public function render()
    {
        return view('livewire.auth.teacher-register');
    }

    public function register()
    {
        try {

            $this->validate();


            $isMatchPassword = $this->password === $this->confirm_password;
            if (!$isMatchPassword) {
                session()->flash('error', 'Password dan konfirmasi password tidak cocok.');
                return $this->redirect('/teacher/register', navigate: true);
            }

            $teacher = Teacher::where('nik', $this->nik)->first();
            if (!$teacher) {
                session()->flash('error', 'NIK tidak ditemukan.');
                return $this->redirect('/teacher/register', navigate: true);
            }

            if ($teacher->account) {
                session()->flash('error', 'NIK sudah memiliki akun.');
                return $this->redirect('/teacher/register', navigate: true);
            }

            $teacher->update([
                'password' => bcrypt($this->password),
                'account' => true,
            ]);




            session()->flash('success', 'Success membuat akun guru. Silakan login.');
            return $this->redirect('/teacher/login', navigate: true);
        } catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                $messages = collect($e->errors())->flatten()->implode(' ');
                session()->flash('error', 'Registration failed. ' . $messages);
            } else {
                session()->flash('error', 'Registration failed. ' . $e->getMessage());
            }
        }
    }
}
