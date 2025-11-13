<?php

use App\Http\Controllers\AdminActivityController;
use App\Http\Controllers\AdminAssessmentTypeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminGradeController;
use App\Http\Controllers\AdminGroupController;
use App\Http\Controllers\AdminPaymentTypeController;
use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\AdminSubjectController;
use App\Http\Controllers\AdminTeacherController;
use App\Http\Controllers\TeacherAssessmentController;
use App\Http\Controllers\TeacherAttendanceController;
use App\Http\Controllers\TeacherPaymentController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\TeacherMiddleware;
use App\Livewire\Admin\Activity\AdminActivityList;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AssessmentType\AdminAssessmentTypeList;
use App\Livewire\Admin\Grade\AdminGradeList;
use App\Livewire\Admin\GradeFee\AdminGradeFeeList;
use App\Livewire\Admin\Group\AdminGroupList;
use App\Livewire\Admin\PaymentType\AdminPaymentTypeList;
use App\Livewire\Admin\Schedule\AdminScheduleList;
use App\Livewire\Admin\Setting\AdminSetting;
use App\Livewire\Admin\Student\AdminStudentList;
use App\Livewire\Admin\Subject\AdminSubjectList;
use App\Livewire\Admin\Teacher\AdminTeacherList;
use App\Livewire\Auth\AdminLogin;
use App\Livewire\Auth\TeacherLogin;
use App\Livewire\Auth\TeacherRegister;
use App\Livewire\Teacher\Assessment\Create\AssessmentStudentList;
use App\Livewire\Teacher\Assessment\Read\AssessmentStudentRead;
use App\Livewire\Teacher\Assessment\Report\AssessmentStudentReport;
use App\Livewire\Teacher\Assessment\TeacherAssessmentMenu;
use App\Livewire\Teacher\Attendance\Create\AttendanceStudentList;
use App\Livewire\Teacher\Attendance\Read\AttendanceStudentRead;
use App\Livewire\Teacher\Attendance\Report\AttendanceStudentReport;
use App\Livewire\Teacher\Attendance\TeacherAttendanceMenu;
use App\Livewire\Teacher\Payment\Create\PaymentStudentCreate;
use App\Livewire\Teacher\Payment\Fee\PaymentFeeDetail;
use App\Livewire\Teacher\Payment\Fee\PaymentFeeList;
use App\Livewire\Teacher\Payment\Read\PaymentReadList;
use App\Livewire\Teacher\Payment\Read\PaymentStudentRead;
use App\Livewire\Teacher\Payment\Report\PaymentReportList;
use App\Livewire\Teacher\Payment\TeacherPaymentMenu;
use App\Livewire\Teacher\Profile\TeacherProfileMenu;
use App\Livewire\Teacher\TeacherDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/teacher/login');
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
    Route::get('/admin/setting', AdminSetting::class);
    Route::get('/admin/assessment/type', AdminAssessmentTypeList::class);

    // file upload route
    Route::post('/admin/teacher/upload', [AdminTeacherController::class, 'uploadFile']);
    Route::post('/admin/grade/upload', [AdminGradeController::class, 'uploadFile']);
    Route::post('/admin/group/upload', [AdminGroupController::class, 'uploadFile']);
    Route::post('/admin/student/upload', [AdminStudentController::class, 'uploadFile']);
    Route::post('/admin/subject/upload', [AdminSubjectController::class, 'uploadFile']);
    Route::post('/admin/schedule/upload', [AdminScheduleController::class, 'uploadFile']);
    Route::post('/admin/activity/upload', [AdminActivityController::class, 'uploadFile']);
    Route::post('/admin/payment/type/upload', [AdminPaymentTypeController::class, 'uploadFile']);
    Route::post('/admin/assessment/type/upload', [AdminAssessmentTypeController::class, 'uploadFile']);
});

Route::middleware(TeacherMiddleware::class)->group(function () {
    Route::get('/teacher/dashboard', TeacherDashboard::class);
    Route::get('/teacher/attendance', TeacherAttendanceMenu::class);
    Route::get('/teacher/attendance/create', AttendanceStudentList::class);
    Route::get('/teacher/attendance/read', AttendanceStudentRead::class);
    Route::get('/teacher/attendance/report', AttendanceStudentReport::class);
    Route::get('/teacher/attendance/report/generate', [TeacherAttendanceController::class, 'generateReport']);

    Route::get('/teacher/payment', TeacherPaymentMenu::class);
    Route::get('/teacher/payment/create', PaymentStudentCreate::class);
    Route::get('/teacher/payment/read', PaymentStudentRead::class);
    Route::get('/teacher/payment/read/detail', PaymentReadList::class);
    Route::get('/teacher/payment/receipt/generate', [TeacherPaymentController::class, 'genereateReceipt']);
    Route::get('/teacher/payment/fee', PaymentFeeList::class);
    Route::get('/teacher/payment/fee/detail', PaymentFeeDetail::class);
    Route::get('/teacher/payment/report', PaymentReportList::class);
    Route::get('/teacher/payment/report/generate', [TeacherPaymentController::class, 'generateReport']);

    Route::get('/teacher/assessment', TeacherAssessmentMenu::class);
    Route::get('/teacher/assessment/create', AssessmentStudentList::class);
    Route::get('/teacher/assessment/read', AssessmentStudentRead::class);
    Route::get('/teacher/assessment/report', AssessmentStudentReport::class);
    Route::get('/teacher/assessment/report/generate', [TeacherAssessmentController::class, 'generateReport']);

    Route::get('/teacher/profile', TeacherProfileMenu::class);
});




Route::get('/teacher/login', TeacherLogin::class);
Route::get('/teacher/register', TeacherRegister::class);
