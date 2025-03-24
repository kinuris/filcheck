<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\EmployeeLog;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboardView()
    {
        $departments = Department::all();
        $events = Event::ongoingEvents()
            ->get()
            ->merge(
                Event::upcomingEvents()
                    ->get()
            );

        $logs = EmployeeLog::query()
            ->where('created_at', '>=', now()->startOfDay())
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard')
            ->with('departments', $departments)
            ->with('logs', $logs)
            ->with('events', $events);
    }
}
