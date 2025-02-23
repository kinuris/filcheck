@extends('layouts.teacher')

@section('title', 'Your Classes')

@section('content')
<div class="w-full p-6 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 max-h-screen overflow-auto">
    <div class="container mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h1 class="text-gray-800 text-4xl font-bold mb-2">Section Advisories</h1>

            @php($advisedSections = Auth::user()->advisedSections)
            <p class="text-gray-600 mb-4">Advised Sections: {{ count($advisedSections) }}</p>

            <div class="flex flex-wrap gap-2">
                @foreach ($advisedSections as $section)
                <span
                    class="text-blue-600 bg-blue-100 px-4 py-2 rounded-full text-sm font-medium">{{ $section->section }}</span>
                @endforeach
            </div>
        </div>

        <h2 class="text-2xl font-bold text-white mb-6">Your Classes</h2>
        @php($classes = Auth::user()->classes)

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($classes as $class)
            <div class="bg-white rounded-xl shadow-lg p-6 transition-transform hover:scale-105">
                <h3 class="text-xl font-bold text-gray-800">{{ $class->subject->name }}</h3>
                <div class="mt-4 space-y-2">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        Rm. {{ $class->room->name }} - {{ $class->room->building }}
                    </div>
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ \Carbon\Carbon::parse($class->start_time)->format('g:i A') }} -
                        {{ \Carbon\Carbon::parse($class->end_time)->format('g:i A') }}
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach (json_decode($class->days_recurring) as $day)
                        <span
                            class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-md">{{ $day }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('class.attendance.view', ['sched' => $class->id]) }}"
                        class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        View Class
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                    <div class="flex-1"></div>
                    <a href="{{ route('class.events', ['schedule' => $class->id]) }}"
                        class="inline-flex items-center text-green-600 hover:text-green-800 font-medium">
                        Events
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection