@extends('layouts.teacher')

@php($advisedSections = Auth::user()->advisedSections)

@section('content')
<div class="max-h-screen min-h-screen overflow-auto w-full bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-6">Teacher Dashboard</h1>

        <!-- Attendance Statistics Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Advisory Attendance Statistics</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-700">Present Today</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $presentCount ?? 0 }}</p>
                    <p class="text-sm text-gray-500">{{ $presentPercentage ?? '0' }}% of students</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-700">Absent Today</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $absentCount ?? 0 }}</p>
                    <p class="text-sm text-gray-500">{{ $absentPercentage ?? '0' }}% of students</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="" class="text-blue-600 hover:text-blue-800 font-medium">View detailed attendance report →</a>
            </div>
        </div>

        <!-- Advisories Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Your Advisories & Classes</h2>
            <div class="flex items-center space-x-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 w-1/2">
                    <h3 class="text-lg font-medium text-gray-700">Total Advisories</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ count($advisedSections) }}</p>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 w-1/2">
                    <h3 class="text-lg font-medium text-gray-700">Classes Today</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $todayClassesCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Classes for the next 12 hours -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Classes for today</h2>
            <div class="overflow-x-auto">
                <div class="flex space-x-4 pb-3 overflow-x-scroll">
                    @forelse($upcomingClasses ?? [
                        (object)[
                            'subject' => 'Mathematics',
                            'start_time' => '09:30:00',
                            'section' => 'Grade 10-A',
                            'room' => 'Room 301'
                        ],
                        (object)[
                            'subject' => 'Science',
                            'start_time' => '11:00:00',
                            'section' => 'Grade 9-B',
                            'room' => 'Laboratory 2'
                        ],
                        (object)[
                            'subject' => 'History',
                            'start_time' => '13:15:00',
                            'section' => 'Grade 11-C',
                            'room' => 'Room 405'
                        ],
                        (object)[
                            'subject' => 'English',
                            'start_time' => '15:00:00',
                            'section' => 'Grade 8-D',
                            'room' => 'Room 201'
                        ]
                    ] as $class)
                        <div class="flex-shrink-0 w-64 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-lg font-medium text-gray-700">{{ $class->subject ?? 'Class' }}</h3>
                                <span class="px-2 py-1 bg-blue-100 text-xs rounded-full text-blue-800">
                                    {{ isset($class->start_time) ? date('h:i A', strtotime($class->start_time)) : 'N/A' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-1">{{ $class->section ?? 'Section' }}</p>
                            <p class="text-xs text-gray-500">
                                <span class="font-medium">Room:</span> {{ $class->room ?? 'TBA' }}
                            </p>
                        </div>
                    @empty
                        <div class="w-full text-center py-4 text-gray-500">
                            No classes scheduled in the next 12 hours
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Dashboard Cards -->
            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Classes</h2>
                <p class="text-gray-600">Manage your classes and schedules</p>
                <div class="flex-1"></div>
                <a href="/attendance/class" class="block w-fit mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">View Classes</a>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Students</h2>
                <p class="text-gray-600">View student information and progress</p>
                <div class="flex-1"></div>
                <a href="/student" class="block w-fit mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">View Students</a>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 flex flex-col">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Attendance Log</h2>
                <p class="text-gray-600">View and manage student attendance records</p>
                <div class="flex-1"></div>
                <a href="/attendance" class="block w-fit mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">View Attendance Logs</a>
            </div>
        </div>
    </div>
</div>
@endsection