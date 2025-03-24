<?php

namespace App\Http\Controllers;

use App\Models\User;

class EmployeeController extends Controller
{
    public function attendanceView()
    {
        $users = User::query()->where('role', '=', 'Teacher');
        $lateThreshold =  request('threshold', now()->startOfDay()->addHours(8));

        $filter = request('filter');
        if ($filter) {
            $users = $users->whereRelation('latestLog', 'created_at', '>', now()->startOfDay())
                ->whereRelation('latestLog', 'type', '=', $filter);
        }

        $search = request('search');
        if ($search) {
            $users = $users->where(function($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('middle_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('rfid', 'like', "%{$search}%");
            });
        }

        $department = request('department');
        if ($department) {
            $users = $users->where('department_id', '=', $department);
        }

        $gender = request('gender');
        if ($gender) {
            $users = $users->where('gender', '=', $gender);
        }

        $users = $users->paginate(7);

        return view('employee.attendance')
            ->with('users', $users)
            ->with('lateThreshold', $lateThreshold);
    }

}
