<?php

namespace App\Http\Controllers;

use App\Models\StudentInfo;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $infos = StudentInfo::query();

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

        $fileName = $info->last_name . '_attendance_logs.csv';
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
