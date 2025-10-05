<?php

namespace App\Livewire\Auth;

use App\Models\AdminCredential;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AdminLogin extends Component
{
    #[Layout('components.layouts.auth')]
    #[Title('Admin Login')]

    public $username = "";
    public $password = "";

    public function render()
    {
        return view('livewire.auth.admin-login');
    }

    public function login()
    {
        try {

            $adminDb = AdminCredential::first();

            if ($adminDb) {
                if (!Hash::check($this->password, $adminDb->password)) {
                    session()->flash('error', 'Username atau password salah.');
                    return $this->redirect('/admin/login', navigate: true);
                }

                if ($this->username !== $adminDb->username) {
                    session()->flash('error', 'Username atau password salah.');
                    return $this->redirect('/admin/login', navigate: true);
                }
                $dataSession = [
                    'username' => $this->username,
                    'role' => "admin"
                ];

                session(['user_admin' => $dataSession]);

                return $this->redirect('/admin/dashboard', navigate: true);
            }


            $envUsername = env('DEFAULT_ADMIN_USERNAME');
            $envPassword = env('DEFAULT_ADMIN_PASSWORD');

            $isCorrectCredentials = $this->username === $envUsername && $this->password === $envPassword;

            if (!$isCorrectCredentials) {
                session()->flash('error', 'Username atau password salah.');
                return $this->redirect('/admin/login', navigate: true);
            }

            $dataSession = [
                'username' => $this->username,
                'role' => "admin"
            ];

            session(['user_admin' => $dataSession]);

            return $this->redirect('/admin/dashboard', navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Login failed. Please check your credentials.');
        }
    }
}
