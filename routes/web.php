<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $user = Auth::user();

    if ($user->role === 'Admin') {
        return redirect('/admin/dashboard');
    } else if ($user->role === 'Teacher') {
        return redirect('/teacher/dashboard');
    } else if ($user->role === 'Student') {
        return redirect('/student/dashboard');
    }
});

Route::controller(AdminController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/admin/dashboard', 'dashboardView');
    });

Route::controller(TeacherController::class)
    ->middleware('role:Teacher')
    ->group(function () {
        Route::get('/teacher/dashboard', 'dashboardView');
    });

Route::controller(TeacherController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/teacher', 'index');

        Route::get('/teacher/create', 'create');
        Route::post('/teacher/create', 'store');

        Route::get('/teacher/edit/{teacher}', 'edit');
        Route::post('/teacher/edit/{teacher}', 'update');
    });

Route::controller(StudentController::class)
    ->middleware('role:Teacher')
    ->group(function () {
        Route::get('/student', 'index');

        Route::get('/student/create', 'create');
        Route::post('/student/create', 'store');

        Route::get('/student/edit/{student}', 'edit');
        Route::post('/student/edit/{student}', 'update');

        Route::post('/student/guardian/notify/{student}', 'smsNotifyGuardian');
    });

Route::get('/rfid', [StudentController::class, 'studentView']);
Route::get('/student/get/{rfid}', [StudentController::class, 'get']);
Route::get('/student/log/{rfid}', [StudentController::class, 'log']);

Route::controller(AttendanceController::class)
    ->middleware('role:Teacher')
    ->group(function () {
        Route::get('/attendance', 'index');
        Route::get('/attendance/record/csv/{info}', 'generate_csv_file');
        Route::get('/attendance/record/pdf/{info}', 'generate_pdf_file');
    });

Route::get('/login', [AuthController::class, 'loginView'])
    ->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');
