<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
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
    ->middleware('role:Teacher,Admin')
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
Route::post('/student/log/{rfid}', [StudentController::class, 'log']);

Route::controller(EmployeeController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/employee', 'attendanceView');
    });

Route::controller(AttendanceController::class)
    ->middleware('role:Teacher')
    ->group(function () {
        Route::get('/attendance', 'index');

        Route::get('/attendance/record/csv/{info}', 'generate_csv_file');
        Route::get('/attendance/record/pdf/{info}', 'generate_pdf_file');
    });

Route::get('/attendance/record/{rfid}/{sched}', [AttendanceController::class, 'log'])->name('class.log');

Route::controller(CurriculumController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/curriculum', 'index');
    });

Route::get('/attendance/class', [CurriculumController::class, 'classAttendance'])
    ->middleware('role:Teacher')
    ->name('class.attendance');

Route::get('/attendance/class/{sched}', [CurriculumController::class, 'classAttendanceView'])
    ->middleware('role:Teacher')
    ->name('class.attendance.view');

Route::controller(EventController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/event', 'index');

        Route::get('/event/node', 'nodeView');

        Route::get('/event/create', 'create');
        Route::post('/event/store', 'store');

        Route::get('/event/{event}/edit', 'edit');
        Route::post('/event/{event}/update', 'update');

        Route::get('/event/{event}/delete', 'delete');

        Route::get('/event/node/setup', 'nodeEventLoggerView');
        Route::post('/event/node/setup', 'nodeSetup');
        Route::post('/event/node/attendance/log', 'nodeEventAttendanceLog');
    });

Route::controller(EventController::class)
    ->middleware('role:Teacher')
    ->group(function () {
        Route::get('/event/view', 'teacherView');

        Route::get('/event/{event}/attendance', 'attendanceView')->name('event.attendance');
    });

Route::controller(RoomController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/room/create', 'create')->name('room.create');
        Route::post('/room/create', 'store')->name('room.store');

        Route::delete('/room/delete/{room}', 'destroy')->name('room.delete');
    });

Route::controller(SubjectController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/subject/create', 'create')->name('subject.create');
        Route::post('/subject/create', 'store')->name('subject.store');

        Route::delete('/subject/delete/{subject}', 'destroy')->name('subject.delete');
    });

Route::controller(RoomScheduleController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::post('/roomschedule/create', 'store')->name('room-schedule.create');
        Route::delete('/roomschedule/delete/{roomSchedule}', 'destroy')->name('room-schedule.delete');
    });

Route::post('/class-node-setup', [RoomScheduleController::class, 'classNodeSetup'])
    ->name('class-node.setup');

Route::get('/class-node/{room}', [RoomScheduleController::class, 'classNodeView'])
    ->name('class-node.view');


Route::get('/login', [AuthController::class, 'loginView'])
    ->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');
