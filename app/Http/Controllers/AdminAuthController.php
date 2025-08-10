<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function logout(Request $request)
    {
        try {
            // Hapus session
            $request->session()->forget('user_admin');
            $request->session()->flush();

            // Redirect ke halaman login
            return redirect('/admin/login')->with('success', 'Anda berhasil logout');
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while logging out.');
            return redirect('/admin/dashboard');
        }
    }
}
