@extends('layouts.teacher')

@section('content')
@php($teacher = Auth::user())
<div class="p-6 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 w-full">
    <div class="bg-white rounded-lg p-6 mb-6">
        <h1 class="text-blue-500 text-3xl">Events in your handled sections</h1>

        @php($advisedSections = $teacher->advisedSections)
        <p class="text-gray-700 mt-5">Advised Sections: {{ count($advisedSections) }}</p>

        <div class="flex mt-1 gap-1.5">
            @foreach($advisedSections as $section)
            <p class="text-white bg-blue-500 p-2 rounded-lg">{{ $section->section }}</p>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-lg p-6">
        <p class="text-2xl text-blue-500">Events (Click to view attendance)</p>
        <div class="mt-4">
            <label for="event-filter">Filter Events:</label>
            <select onchange="window.location.href = '?event=' + this.value;" id="event-filter" name="event-filter" class="ml-2 p-2 rounded-lg border">
                @php($selectedEvent = request('event'))
                <option value="ongoing" {{ $selectedEvent == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="future" {{ $selectedEvent == 'future' ? 'selected' : '' }}>Future</option>
                <option value="past" {{ $selectedEvent == 'past' ? 'selected' : '' }}>Past</option>
            </select>
        </div>

        <hr class="mt-3">
        <div class="flex gap-2 mt-3 flex-wrap">
            @if($events->isEmpty())
                <p class="text-gray-700 text-2xl my-3">(No Events)</p>
            @endif

            @foreach($events as $event)
            <a href="{{ route('event.attendance', ['event' => $event->id]) }}" class="bg-white shadow-md rounded-lg p-4 w-1/4 hover:bg-blue-100 transition duration-100">
                <h2 class="text-xl font-bold">{{ $event->name }}</h2>
                <p class="text-gray-700">{{ $event->description }}</p>
                <p class="text-gray-700 text-xs">{{ $event->address }}</p>

                <p class="text-gray-500 text-sm mt-4">Start Date: {{ \Carbon\Carbon::parse($event->start)->format('M j, Y g:i A') }}</p>
                <p class="text-gray-500 text-sm">End Date: {{ \Carbon\Carbon::parse($event->end)->format('M j, Y g:i A') }}</p>

                <p class="mt-4">To be Attended By:</p>
                <div class="flex gap-1">
                    @foreach($event->students->whereIn('section', $advisedSections->pluck('section'))->unique('section')->pluck('section') as $section)
                    <p class="bg-blue-500 text-white p-1 rounded">{{ $section }}</p>
                    @endforeach
                </div>
            </a>
            @endforeach
        </div>
        <hr class="mt-3">
    </div>
</div>
@endsection