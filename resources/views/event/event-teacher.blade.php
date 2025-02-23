@extends('layouts.teacher')

@section('title', 'Advisory Events')

@section('content')
    @php($teacher = Auth::user())
    <div class="p-6 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 w-full max-h-screen overflow-auto">
        <div class="bg-white rounded-lg p-6 mb-4">
            <h1 class="text-blue-500 text-3xl">Events in your handled sections</h1>

            @php($advisedSections = $teacher->advisedSections)
            <p class="text-gray-700 mt-2">Advised Sections: {{ count($advisedSections) }}</p>

            <div class="flex mt-1 gap-1.5">
                @foreach ($advisedSections as $section)
                    <p class="text-white bg-blue-500 p-2 rounded-lg">{{ $section->section }}</p>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 shadow-lg">
            <p class="text-2xl text-blue-600 font-semibold mb-6">Events (Click to view attendance)</p>
            <div class="mb-6">
            <label for="event-filter" class="font-medium text-gray-700">Filter Events:</label>
            <select onchange="window.location.href = '?event=' + this.value;" id="event-filter" name="event-filter"
                class="ml-2 p-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @php($selectedEvent = request('event'))
                <option value="ongoing" {{ $selectedEvent == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="future" {{ $selectedEvent == 'future' ? 'selected' : '' }}>Future</option>
                <option value="past" {{ $selectedEvent == 'past' ? 'selected' : '' }}>Past</option>
            </select>
            </div>

            <hr class="border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 my-6">
            @if ($events->isEmpty())
                <p class="text-gray-500 text-xl col-span-full text-center py-8">No events available</p>
            @endif

            @foreach ($events as $event)
                <a href="{{ route('event.attendance', ['event' => $event->id]) }}"
                class="block bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all duration-200">
                <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $event->name }}</h2>
                <p class="text-gray-600 mb-2">{{ $event->description }}</p>
                <p class="text-gray-500 text-sm">{{ $event->address }}</p>

                <div class="my-4 border-t border-gray-100 pt-4">
                    <p class="text-gray-600 text-sm">
                    <span class="font-medium">Start:</span> 
                    {{ \Carbon\Carbon::parse($event->start)->format('M j, Y g:i A') }}
                    </p>
                    <p class="text-gray-600 text-sm">
                    <span class="font-medium">End:</span>
                    {{ \Carbon\Carbon::parse($event->end)->format('M j, Y g:i A') }}
                    </p>
                </div>

                <div>
                    <p class="font-medium text-gray-700 mb-2">To be Attended By:</p>
                    <div class="flex flex-wrap gap-2">
                    @foreach ($event->students->whereIn('section', $advisedSections->pluck('section'))->unique('section')->pluck('section') as $section)
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">{{ $section }}</span>
                    @endforeach
                    </div>
                </div>
                </a>
            @endforeach
            </div>
            <hr class="border-gray-200">
        </div>
    </div>
@endsection
