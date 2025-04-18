<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HolidayController;
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
    ->middleware('role:Teacher,Admin')
    ->group(function () {
        Route::get('/teacher/dashboard', 'dashboardView');

        Route::get('/teacher/{teacher}/destroy', 'destroy')->name('teacher.destroy');
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
        Route::get('/student', 'index')->name('student.index');

        Route::get('/student/create', 'create');
        Route::post('/student/create', 'store');

        Route::get('/student/edit/{student}', 'edit');
        Route::post('/student/edit/{student}', 'update');

        Route::post('/student/guardian/notify/{student}', 'smsNotifyGuardian');

        Route::get('/student/delete/{student}', 'destroy');
        Route::get('/student/decomission/{student}', 'decomission')->name('student.decomission');
    });

Route::get('/rfid', [StudentController::class, 'studentView']);
Route::get('/student/get/{rfid}', [StudentController::class, 'get']);
Route::post('/student/log/{rfid}', [StudentController::class, 'log']);

Route::controller(HolidayController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::post('/holidays/store', 'store')->name('holidays.store');
        Route::delete('/holidays/{holiday}', 'destroy')->name('holidays.destroy');
    });

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

Route::controller(AttendanceController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/teacher/attendance/record/pdf/{user}', 'teacher_generate_pdf_file');
        Route::get('/teacher/attendance/record/csv/{user}', 'teacher_generate_csv_file');
    });

Route::get('/attendance/record/{rfid}/{sched}', [AttendanceController::class, 'log'])->name('class.log');

Route::controller(CurriculumController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/curriculum', 'index');

        Route::get('/curriculum/{schedule}/irregular', 'irregularManage')->name('irregular.index');
        Route::post('/curriculum/{schedule}/irregular/store', 'irregularStore')->name('irregular.store');

        Route::delete('/curriculum/{irregular}/delete', 'irregularDestroy')->name('irregular.destroy');
    });

Route::get('/attendance/class', [CurriculumController::class, 'classAttendance'])
    ->middleware('role:Teacher')    ->name('class.attendance');

Route::get('/attendance/class/{sched}', [CurriculumController::class, 'classAttendanceView'])
    ->middleware('role:Teacher')
    ->name('class.attendance.view');

Route::controller(DepartmentController::class)
    ->middleware('role:Admin')
    ->group(function() {
        Route::get('/department', 'index')->name('department.index');

        Route::get('/department/create', 'create')->name('department.create');
        Route::post('/department/store', 'store')->name('department.store');

        Route::get('/department/edit/{department}', 'edit')->name('department.edit');
        Route::put('/deparment/update/{department}', 'update')->name('department.update');

        Route::delete('/department/delete/{department}', 'destroy')->name('department.destroy');
    });

Route::controller(EventController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/event', 'index')->name('event.index');

        Route::get('/event/node', 'nodeView');

        Route::get('/event/create', 'create');
        Route::post('/event/store', 'store');

        Route::get('/event/{event}/edit', 'edit');
        Route::post('/event/{event}/update', 'update');

        Route::get('/event/{event}/delete', 'delete');
        Route::post('/event/{event}/destroy', 'destroy')->name('event.destroy');

        Route::get('/event/node/setup', 'nodeEventLoggerView');
        Route::post('/event/node/setup', 'nodeSetup');
        Route::post('/event/node/attendance/log', 'nodeEventAttendanceLog');

    });

Route::controller(EventController::class)
    ->middleware('role:Teacher')
    ->group(function () {
        Route::get('/event/view', 'teacherView');

        Route::get('/event/{event}/attendance', 'attendanceView')->name('event.attendance');

        Route::get('/attendance/event/class/{schedule}', 'classEvents')->name('class.events');
        Route::post('/attendance/event/class/{schedule}/create', 'createClassEvent')->name('class.event-create');

        Route::get('/attendance/{schedule}/event/{event}', 'attendanceClassView')->name('class.event-attendance');
    });

Route::controller(RoomController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/room/create', 'create')->name('room.create');
        Route::post('/room/create', 'store')->name('room.store');

        Route::get('/room/edit/{room}', 'edit')->name('room.edit');
        Route::post('/room/update/{room}', 'update')->name('room.update');

        Route::delete('/room/delete/{room}', 'destroy')->name('room.delete');
    });

Route::controller(SubjectController::class)
    ->middleware('role:Admin')
    ->group(function () {
        Route::get('/subject/create', 'create')->name('subject.create');
        Route::post('/subject/create', 'store')->name('subject.store');

        Route::get('/subject/edit/{subject}', 'edit')->name('subject.edit');
        Route::post('/subject/update/{subject}', 'update')->name('subject.update');       

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
    ->middleware('guest')
    ->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])
    ->middleware('auth');
