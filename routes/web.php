<?php

use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Auth\AdminLogin;
use App\Livewire\Auth\TeacherLogin;
use App\Livewire\Auth\TeacherRegister;
use App\Livewire\CreatePost;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/login', AdminLogin::class);
Route::get('/admin/dashboard', AdminDashboard::class);;


Route::get('/teacher/login', TeacherLogin::class);
Route::get('/teacher/register', TeacherRegister::class);
