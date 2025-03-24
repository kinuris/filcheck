@extends('layouts.teacher')

@php($advisedSections = Auth::user()->advisedSections)

@section('content')
<div class="max-h-screen min-h-screen overflow-auto w-full bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-6">Teacher Dashboard</h1>

        <!-- Attendance Statistics Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Advisory Attendance Statistics</h2>
            <p class="text-lg text-gray-600 mb-4">Total Students: <span class="font-bold">{{ count($present) + count($absent) }}</span></p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-700">Present Today</h3>
                    <p class="text-3xl font-bold text-green-600">{{ count($present) }}</p>
                    <p class="text-sm text-gray-500">{{ number_format(count($present) / (count($present) + count($absent)) * 100, 2) }}% of students</p>
                </div>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-700">Absent Today</h3>
                    <p class="text-3xl font-bold text-red-600">{{ count($absent) }}</p>
                    <p class="text-sm text-gray-500">{{ number_format(count($absent) / (count($present) + count($absent)) * 100, 2) }}% of students</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="" class="text-blue-600 hover:text-blue-800 font-medium">View detailed attendance report →</a>
            </div>
        </div>

        <!-- Events Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Upcoming & Ongoing Events</h2>
            <div class="overflow-x-auto">
                <div class="flex space-x-4 pb-3 overflow-x-scroll">
                    @forelse($events ?? [] as $event)
                    <div class="flex-shrink-0 w-80 bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-lg p-5 shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $event->name }}</h3>
                            <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-medium">Event</span>
                        </div>
                        <div class="flex space-x-3 mb-3">
                            <div class="bg-white rounded-md border border-gray-200 px-3 py-2 text-center w-1/2 shadow-sm">
                                <span class="block text-xs uppercase tracking-wide text-gray-500 font-medium">Start</span>
                                <span class="font-semibold text-sm text-gray-800">{{ date('M d, Y', strtotime($event->start)) }}</span>
                                <span class="block text-xs text-blue-600 mt-1">{{ $event->time }}</span>
                            </div>
                            <div class="bg-white rounded-md border border-gray-200 px-3 py-2 text-center w-1/2 shadow-sm">
                                <span class="block text-xs uppercase tracking-wide text-gray-500 font-medium">End</span>
                                <span class="font-semibold text-sm text-gray-800">{{ date('M d, Y', strtotime($event->end)) }}</span>
                                <span class="block text-xs text-blue-600 mt-1">{{ $event->time }}</span>
                            </div>
                        </div>
                        <div class="flex items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-xs text-gray-600">{{ $event->address }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="w-full text-center py-4 text-gray-500">
                        No upcoming events
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Advisories Section -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Your Advisories & Classes</h2>
            <div class="flex gap-2 mb-4">
                @foreach($advisories as $section)
                <div class="bg-gray-50 border border-gray-200 rounded p-1 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <h3 class="text-sm text-gray-600">{{ $section->section }}</h3>
                </div>
                @endforeach
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 w-1/2">
                    <h3 class="text-lg font-medium text-gray-700">Total Advisories</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ count($advisedSections) }}</p>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 w-1/2">
                    <h3 class="text-lg font-medium text-gray-700">Classes Today</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ count($classesForToday) }}</p>
                </div>
            </div>
        </div>

        <!-- Classes for the next 12 hours -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Classes for today</h2>
            <div class="overflow-x-auto">
                <div class="flex space-x-4 pb-3 overflow-x-scroll">
                    @forelse($classesForToday ?? [] as $class)
                    <div class="flex-shrink-0 w-96 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex gap-2 items-center mb-2">
                            <h3 class="text-lg font-medium text-gray-700">{{ $class->subject->name ?? 'Class' }}</h3>
                            <div class="flex-1"></div>
                            <span class="px-2 py-1 bg-blue-100 text-xs rounded-full text-blue-800">
                                {{ isset($class->start_time) ? date('h:i A', strtotime($class->start_time)) : 'N/A' }}
                            </span>
                            <p class="text-sm">to</p>
                            <span class="px-2 py-1 bg-blue-100 text-xs rounded-full text-blue-800">
                                {{ isset($class->start_time) ? date('h:i A', strtotime($class->end_time)) : 'N/A' }}
                            </span>
                        </div>
                        @php($combined = $class->regulars()->merge($class->irregulars()->get()))
                        <p class="text-sm text-gray-600 mb-1">{{ $class->section ?? 'Section' }} ({{ count($combined) }} students)</p>
                        <p class="text-xs text-gray-500">
                            <span class="font-medium">Room:</span> {{ $class->room->name }} @ {{ $class->room->building }}
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