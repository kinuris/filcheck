<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLog;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function attendanceView()
    {
        $users = User::query()->where('role', '=', 'Teacher');

        $filter = request('filter');
        if ($filter) {
            $users = $users->whereRelation('latestLog', 'type', '=', $filter);
        }

        $users = $users->paginate(7);

        return view('employee.attendance')->with('users', $users);
    }

}
