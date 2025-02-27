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
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 my-6">
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $event->address }}
                    </p>

                    <div class="my-4 border-t border-gray-100 pt-4">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium text-gray-700">Schedule:</span>
                        </div>
                        <p class="text-gray-600 text-sm ml-6">
                            {{ \Carbon\Carbon::parse($event->start)->format('M j, Y g:i A') }} - 
                            {{ \Carbon\Carbon::parse($event->end)->format('M j, Y g:i A') }}
                        </p>
                    </div>

                    <div>
                        <p class="font-medium text-gray-700 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Participants:
                        </p>
                        <div class="flex flex-wrap gap-2 ml-6">
                        @foreach ($event->students->whereIn('section', $advisedSections->pluck('section'))->unique('section')->pluck('section') as $section)
                            <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">{{ $section }}</span>
                        @endforeach
                        </div>
                    </div>
                </a>
            @endforeach
            </div>
        </div>
    </div>
@endsection
