@extends('layouts.teacher')

@section('title', 'Advisory Events')

@section('content')
@php($teacher = Auth::user())
<div class="p-8 bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 w-full max-h-screen overflow-auto">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h1 class="text-blue-600 text-3xl font-bold">Events Dashboard</h1>

        @php($advisedSections = $teacher->advisedSections)
        <p class="text-gray-600 mt-2 mb-4">You are currently advising {{ count($advisedSections) }} section(s)</p>

        <div class="flex flex-wrap mt-2 gap-2">
            @foreach ($advisedSections as $section)
            <span class="text-white bg-blue-600 px-3 py-1 rounded-md text-sm font-medium shadow-sm">{{ $section->section }}</span>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg p-8 shadow-lg">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl text-gray-800 font-bold">Events</h2>
            <div>
                <label for="event-filter" class="font-medium text-gray-700 mr-2">Filter:</label>
                <select onchange="window.location.href = '?event=' + this.value;" id="event-filter" name="event-filter"
                    class="p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 shadow-sm bg-white">
                    @php($selectedEvent = request('event'))
                    <option value="ongoing" {{ $selectedEvent == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="future" {{ $selectedEvent == 'future' ? 'selected' : '' }}>Future</option>
                    <option value="past" {{ $selectedEvent == 'past' ? 'selected' : '' }}>Past</option>
                </select>
            </div>
        </div>

        <hr class="border-gray-200 mb-6">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-6">
            @if ($events->isEmpty())
            <div class="col-span-full bg-gray-50 rounded-lg p-8 text-center">
                <p class="text-gray-500 text-xl">No events available</p>
            </div>
            @endif

            @foreach ($events as $event)
            <a href="{{ route('event.attendance', ['event' => $event->id]) }}"
                class="block bg-white rounded-xl p-6 shadow hover:shadow-lg border border-gray-100 hover:border-blue-300 transition-all duration-200">
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $event->name }}</h3>
                <p class="text-gray-600 mb-3">{{ $event->description }}</p>
                <p class="text-gray-500 text-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    {{ $event->address }}
                </p>

                <div class="my-4 border-t border-gray-100 pt-4">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-700 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-semibold text-gray-700">Schedule:</span>
                    </div>
                    <div class="ml-6 grid grid-cols-2 gap-3">
                        <div class="bg-blue-50 rounded-md p-2">
                            <span class="text-xs text-gray-500 block">Start</span>
                            <span class="text-gray-700 font-medium">
                                {{ \Carbon\Carbon::parse($event->start)->format('M j, Y') }}
                            </span>
                            <span class="text-gray-600 text-sm block">
                                {{ \Carbon\Carbon::parse($event->start)->format('g:i A') }}
                            </span>
                        </div>
                        <div class="bg-blue-50 rounded-md p-2">
                            <span class="text-xs text-gray-500 block">End</span>
                            <span class="text-gray-700 font-medium">
                                {{ \Carbon\Carbon::parse($event->end)->format('M j, Y') }}
                            </span>
                            <span class="text-gray-600 text-sm block">
                                {{ \Carbon\Carbon::parse($event->end)->format('g:i A') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="font-semibold text-gray-700 mb-2 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-700 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        Participants:
                    </p>
                    <div class="flex flex-wrap gap-2 ml-6">
                        @foreach ($event->students->whereIn('section', $advisedSections->pluck('section'))->unique('section')->pluck('section') as $section)
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium shadow-sm">{{ $section }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
                    <span class="inline-flex items-center text-blue-700 text-sm font-medium hover:text-blue-800">
                        Manage attendance
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endsection