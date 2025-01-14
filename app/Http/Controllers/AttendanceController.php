<?php

namespace App\Http\Controllers;

use App\Models\RoomSchedule;
use App\Models\ScheduleAttendanceRecord;
use App\Models\StudentInfo;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function log(string $rfid, RoomSchedule $sched)
    {
        $student = StudentInfo::query()
            ->where('rfid', '=', $rfid)
            ->first();

        if ($student == null || $student->section !== $sched->section) {
            return response()->json([
                'status' => 'ssnf',
                'message' => 'Student not found or not in the same section as the schedule.',
            ]);
        }

        $latestLog = ScheduleAttendanceRecord::query()
            ->where('student_info_id', '=', $student->id)
            ->where('room_schedule_id', '=', $sched->id)
            ->latest()
            ->first();

        if ($latestLog != null && $latestLog->type === 'IN') {
            $log = ScheduleAttendanceRecord::create([
                'student_info_id' => $student->id,
                'room_schedule_id' => $sched->id,
                'day' => date_create()->format('Y-m-d'),
                'time' => date_create()->format('H:i:s'),
                'type' => 'OUT',
            ]);

            $data = [
                'profile' => $student->image(),
                'fullname' => $student->fullname,
                'section' => $student->section,
                'year' => $student->year,
                'date' => $log->day,
                'time' => date_create($log->time)->format('h:i A'),
            ];

            return response()->json([
                'status' => 'success',
                'message' => $student->fullname .  ' exited at ' . $log->created_at,
                'student' => json_encode($data),
            ]);
        }

        $log = ScheduleAttendanceRecord::create([
            'student_info_id' => $student->id,
            'room_schedule_id' => $sched->id,
            'day' => date_create()->format('Y-m-d'),
            'time' => date_create()->format('H:i:s'),
            'type' => 'IN',
        ]);

        $data = [
            'profile' => $student->image(),
            'fullname' => $student->fullname,
            'section' => $student->section,
            'year' => $student->year,
            'date' => $log->day,
            'time' => date_create($log->time)->format('h:i A'),
        ];

        return response()->json([
            'status' => 'success',
            'message' => $student->fullname . ' entered at ' . $log->created_at,
            'student' => json_encode($data),
        ]);
    }

    public function index()
    {
        $infos = StudentInfo::query();
        $advisedSections = User::query()->find(Auth::user()->id)->advisedSections;

        $infos = $infos->whereIn('section', $advisedSections->pluck('section'));

        $search = request('search');
        if ($search) {
            $infos = $infos->where('first_name', 'like', '%' . $search . '%')
                ->orWhere('middle_name', 'like', '%' . $search . '%')
                ->orWhere('last_name', 'like', '%' . $search . '%');
        }

        $filter = request('filter');
        if ($filter) {
            $infos = $infos->whereRelation('latestLog', 'type', '=', $filter);
        }

        $infos = $infos->paginate(5);

        return view('attendance.manage')->with('infos', $infos);
    }

    public function generate_csv_file(StudentInfo $info)
    {
        $handle = fopen('php://output', 'w');

        $cb = function () use ($handle, $info) {
            $logs = $info->gateLogs()->get();

            fputcsv($handle, ['DATE', 'TIME', 'ACTION']);
            foreach ($logs as $log) {
                fputcsv($handle, [$log->day, $log->time, $log->type]);
            }
        };

        $fileName = $info->last_name . '_' . date_create()->format('Y_m_d') . '_att_logs' . '.csv';
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        return response()->stream($cb, 200, $headers);
    }

    public function generate_pdf_file(StudentInfo $info)
    {
        return view('attendance.pdf-generate', ['info' => $info]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
