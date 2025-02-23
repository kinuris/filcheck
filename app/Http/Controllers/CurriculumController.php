<?php

namespace App\Http\Controllers;

use App\Models\IrregularRoomSchedule;
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
        if (request()->mode === 'Irreg') {
            $students = $sched->irregulars()
                ->get()
                ->map(fn($irreg) => $irreg->student)
                ->filter(fn($student) => !$student->disabled());
        } else {
            $students = StudentInfo::query()
                ->where('section', '=', $sched->section)
                ->whereDoesntHave('disabledRelation')
                ->get();
        }

        return view('curriculum.class-attendance-record')
            ->with('students', $students)
            ->with('class', $sched);
    }

    public function irregularManage(RoomSchedule $schedule)
    {
        return view('curriculum.irregular')
            ->with('schedule', $schedule)
            ->with('irregulars', $schedule->irregulars()->get());
    }

    public function irregularStore(Request $request, RoomSchedule $schedule)
    {
        $request->validate([
            'days' => 'required|array',
            'student_id' => [
                'required',
                'integer',
                'exists:student_infos,id',
                'unique:irregular_room_schedules,student_info_id',
            ],
        ], [
            'student_id.unique' => 'This student is already enrolled in this class.',
        ]);

        $irregular = new IrregularRoomSchedule();

        $irregular->room_schedule_id = $schedule->id;
        $irregular->student_info_id = $request->student_id;
        $irregular->days_recurring = json_encode($request->days);

        $irregular->save();

        return redirect()->route('irregular.index', ['schedule' => $schedule->id]);
    }

    public function irregularDestroy(IrregularRoomSchedule $irregular)
    {
        $irregular->delete();

        return redirect()->route('irregular.index', ['schedule' => $irregular->room_schedule_id]);
    }
}
