@extends('layouts.teacher')

@section('title', 'Your Classes')

@section('content')
<div class="w-full p-6 bg-gradient-to-r from-blue-800 via-blue-700 to-blue-600 min-h-screen overflow-auto">
    <div class="container mx-auto">
        <div class="bg-white rounded-lg shadow-xl p-8 mb-10">
            <h1 class="text-gray-900 text-3xl font-semibold mb-3">Section Advisories</h1>

            @php($advisedSections = Auth::user()->advisedSections)
            <p class="text-gray-600 mb-6">You are currently advising <span class="font-semibold">{{ count($advisedSections) }}</span> section(s)</p>

            <div class="flex flex-wrap gap-2">
                @foreach ($advisedSections as $section)
                <span class="text-blue-700 bg-blue-50 px-4 py-2 rounded-full text-sm font-medium border border-blue-100">{{ $section->section }}</span>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-semibold text-white">Your Classes</h2>
            <span class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg text-sm">Total: {{ count($classes = Auth::user()->classes) }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($classes as $class)
            <div class="bg-white rounded-lg shadow-xl p-6 transition-all hover:shadow-2xl border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $class->subject->name }}</h3>
                    <span class="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-full">{{ $class->section->section ?? 'No Section' }}</span>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <span>Rm. {{ $class->room->name }} - {{ $class->room->building }}</span>
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }} - 
                        {{ \Carbon\Carbon::parse($class->end_time)->format('g:i A') }}</span>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach (json_decode($class->days_recurring) as $day)
                        <span class="bg-gray-100 text-gray-700 text-xs px-3 py-1 rounded-md font-medium">{{ $day }}</span>
                        @endforeach
                    </div>
                </div>
                <hr class="my-4 border-gray-100">
                <div class="flex items-center justify-between">
                    <a href="{{ route('class.attendance.view', ['sched' => $class->id]) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                        <span>View Class</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('class.events', ['schedule' => $class->id]) }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 text-blue-600 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Events</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection