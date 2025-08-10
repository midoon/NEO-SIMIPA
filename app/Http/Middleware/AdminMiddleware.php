<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (session('user_admin.role') !== 'admin') {
                // Redirect ke login jika tidak memenuhi syarat
                return redirect('/admin/login')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
            }

            return $next($request);
        } catch (\Exception $e) {
            return redirect('/admin/login')->with('error', 'Akses ditolak. Silakan login sebagai admin.');
        }
    }
}
