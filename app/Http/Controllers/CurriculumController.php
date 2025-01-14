<?php

namespace App\Http\Controllers;

use App\Models\RoomSchedule;
use App\Models\StudentInfo;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function index()
    {
        return view('curriculum.index');
    }

    public function classAttendance()
    {
        return view('curriculum.class-attendance');
    }

    public function classAttendanceView(RoomSchedule $sched)
    {
        $students = StudentInfo::query()
            ->where('section', '=', $sched->section)
            ->get();

        return view('curriculum.class-attendance-record')
            ->with('students', $students)
            ->with('class', $sched);
    }
}
