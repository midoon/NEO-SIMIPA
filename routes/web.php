<?php

use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Grade\AdminGradeList;
use App\Livewire\Admin\Teacher\AdminTeacherList;
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
Route::get('/admin/teacher', AdminTeacherList::class);
Route::get('/admin/grade', AdminGradeList::class);

// file upload route
Route::post('/admin/teacher/upload', [App\Http\Controllers\AdminTeacherController::class, 'uploadFile']);

Route::get('/teacher/login', TeacherLogin::class);
Route::get('/teacher/register', TeacherRegister::class);
