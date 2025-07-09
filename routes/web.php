<?php

use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Grade\AdminGradeList;
use App\Livewire\Admin\Group\AdminGroupList;
use App\Livewire\Admin\Student\AdminStudentList;
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
Route::get('/admin/dashboard', AdminDashboard::class);
Route::get('/admin/teacher', AdminTeacherList::class);
Route::get('/admin/grade', AdminGradeList::class);
Route::get('/admin/group', AdminGroupList::class);
Route::get('/admin/student', AdminStudentList::class);

// file upload route
Route::post('/admin/teacher/upload', [App\Http\Controllers\AdminTeacherController::class, 'uploadFile']);
Route::post('/admin/grade/upload', [App\Http\Controllers\AdminGradeController::class, 'uploadFile']);
Route::post('/admin/group/upload', [App\Http\Controllers\AdminGroupController::class, 'uploadFile']);

Route::get('/teacher/login', TeacherLogin::class);
Route::get('/teacher/register', TeacherRegister::class);
