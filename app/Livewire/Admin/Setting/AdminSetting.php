<?php

namespace App\Livewire\Admin\Setting;

use App\Models\AdminCredential;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class AdminSetting extends Component
{
    #[Layout('components.layouts.admin')]
    #[Title('Admin Setting')]

    public $username, $password_old, $password, $confirm_password;

    public function render()
    {
        return view('livewire.admin.setting.admin-setting');
    }

    public function updatePassword()
    {
        $this->validate([
            'username' => 'required',
            'password_old' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password_old.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'confirm_password.required' => 'Konfirmasi password wajib diisi.',
            'confirm_password.same' => 'Konfirmasi password tidak cocok.',
        ]);

        // Validasi konfirmasi password
        if ($this->password != $this->confirm_password) {
            session()->flash('error', 'Konfirmasi password tidak cocok.');
            return;
        }

        $x_old_pw = env('DEFAULT_ADMIN_PASSWORD');
        $createNewUserAdmin = false;

        $countAdmin = AdminCredential::count();
        if ($countAdmin == 0) {
            $createNewUserAdmin = true;
        }

        // Buat credential baru jika belum ada admin
        if ($createNewUserAdmin) {
            if ($this->password_old != $x_old_pw) {
                session()->flash('error', 'Password lama salah.');
                return;
            }

            AdminCredential::create([
                'username' => $this->username,
                'password' => bcrypt($this->password),
            ]);

            session()->flash('success', 'Admin baru berhasil dibuat.');
            return;
        }

        // Update password admin yang sudah ada
        $admin = AdminCredential::first();


        if (!Hash::check($this->password_old, $admin->password)) {
            session()->flash('error', 'Password lama tidak sesuai.');
            return;
        }

        $admin->username = $this->username;
        $admin->password = bcrypt($this->password);
        $admin->save();

        session()->flash('success', 'Password berhasil diperbarui.');

        $this->reset();
    }
}
