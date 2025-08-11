<?php

namespace App\Livewire\Auth;

use App\Models\Teacher;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class TeacherLogin extends Component
{
    #[Layout('components.layouts.auth')]
    #[Title('Teacher Login')]

    public $nik = "";
    public $password = "";

    protected $rules = [
        'nik' => 'required|numeric|digits:16',
        'password' => 'required|min:8|max:255',
    ];
    public function render()
    {
        return view('livewire.auth.teacher-login');
    }

    public function login()
    {
        try {

            $this->validate();

            $teacher = Teacher::where('nik', $this->nik)->first();
            if (!$teacher || !$teacher->account || !password_verify($this->password, $teacher->password)) {
                session()->flash('error', 'Nik atau password salah');
                return $this->redirect('/teacher/login', navigate: true);
            }

            $userDataSession = [
                'name' => $teacher->name,
                'teacherId' => $teacher->id,
                'role' => $teacher->role // need solve
            ];

            session(['teacher' => $userDataSession]);

            return $this->redirect('/teacher/dashboard', navigate: true);
        } catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                $messages = collect($e->errors())->flatten()->implode(' ');
                session()->flash('error', 'Login failed. ' . $messages);
            } else {
                session()->flash('error', 'Login failed. ' . $e->getMessage());
            }
        }
    }
}
