<?php

use App\Http\Controllers\AdminActivityController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminGradeController;
use App\Http\Controllers\AdminGroupController;
use App\Http\Controllers\AdminPaymentTypeController;
use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\AdminSubjectController;
use App\Http\Controllers\AdminTeacherController;
use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Admin\Activity\AdminActivityList;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Grade\AdminGradeList;
use App\Livewire\Admin\GradeFee\AdminGradeFeeList;
use App\Livewire\Admin\Group\AdminGroupList;
use App\Livewire\Admin\PaymentType\AdminPaymentTypeList;
use App\Livewire\Admin\Schedule\AdminScheduleList;
use App\Livewire\Admin\Student\AdminStudentList;
use App\Livewire\Admin\Subject\AdminSubjectList;
use App\Livewire\Admin\Teacher\AdminTeacherList;
use App\Livewire\Auth\AdminLogin;
use App\Livewire\Auth\TeacherLogin;
use App\Livewire\Auth\TeacherRegister;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::get('/admin/login', AdminLogin::class);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

Route::middleware(AdminMiddleware::class)->group(function () {
    Route::get('/admin/dashboard', AdminDashboard::class);
    Route::get('/admin/teacher', AdminTeacherList::class);
    Route::get('/admin/grade', AdminGradeList::class);
    Route::get('/admin/group', AdminGroupList::class);
    Route::get('/admin/student', AdminStudentList::class);
    Route::get('/admin/subject', AdminSubjectList::class);
    Route::get('/admin/schedule', AdminScheduleList::class);
    Route::get('/admin/activity', AdminActivityList::class);
    Route::get('/admin/payment/type', AdminPaymentTypeList::class);
    Route::get('/admin/fee/grade', AdminGradeFeeList::class);

    // file upload route
    Route::post('/admin/teacher/upload', [AdminTeacherController::class, 'uploadFile']);
    Route::post('/admin/grade/upload', [AdminGradeController::class, 'uploadFile']);
    Route::post('/admin/group/upload', [AdminGroupController::class, 'uploadFile']);
    Route::post('/admin/student/upload', [AdminStudentController::class, 'uploadFile']);
    Route::post('/admin/subject/upload', [AdminSubjectController::class, 'uploadFile']);
    Route::post('/admin/schedule/upload', [AdminScheduleController::class, 'uploadFile']);
    Route::post('/admin/activity/upload', [AdminActivityController::class, 'uploadFile']);
    Route::post('/admin/payment/type/upload', [AdminPaymentTypeController::class, 'uploadFile']);
});




Route::get('/teacher/login', TeacherLogin::class);
Route::get('/teacher/register', TeacherRegister::class);
