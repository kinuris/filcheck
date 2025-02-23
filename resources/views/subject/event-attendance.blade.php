@extends('layouts.teacher')

@section('title', 'Event Attendance')

@section('content')
<div class="w-full p-6 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 max-h-screen overflow-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-gray-800 text-4xl font-bold mb-4">Event Attendance</h1>

        <div class="flex flex-col">
            <div class="flex gap-2 mb-4">
                @foreach(json_decode($schedule->days_recurring, true) ?? [$schedule->days_recurring] as $day)
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm font-medium">
                    {{ $day }}
                </div>
                @endforeach
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <span class="text-gray-500 text-sm font-semibold uppercase">Section</span>
                    <p class="text-gray-800 text-lg mt-1">{{ $schedule->section }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <span class="text-gray-500 text-sm font-semibold uppercase">Time Schedule</span>
                    <p class="text-gray-800 text-lg mt-1">{{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-gray-800 text-2xl font-bold mb-4">Events To Attend</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left text-gray-600">Name</th>
                        <th class="px-4 py-2 text-left text-gray-600">Start</th>
                        <th class="px-4 py-2 text-left text-gray-600">End</th>
                        <th class="px-4 py-2 text-left text-gray-600">Status</th>
                        <th class="px-4 py-2 text-left text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $event->name }}</td>
                        <td class="px-4 py-2">{{ date('M. j, y g:i a', strtotime($event->start)) }}</td>
                        <td class="px-4 py-2">{{ date('M. j, y g:i a', strtotime($event->end)) }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-sm 
                                    {{ $event->end < now() ? 'bg-red-100 text-red-800' : 
                                       ($event->start <= now() && $event->end >= now() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $event->end < now() ? 'past' : 
                                   ($event->start <= now() && $event->end >= now() ? 'ongoing' : 'upcoming') }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('class.event-attendance', ['schedule' => $schedule->id, 'event' => $event->id]) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                View Attendance
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    {{-- @foreach(array_merge(App\Models\Event::ongoingEvents()->get()->toArray(), App\Models\Event::upcomingEvents()->get()->toArray()) as $event)
                    @php($event = (object) $event)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $event->name }}</td>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-sm bg-gray-100 text-gray-800">
                            Upcoming
                        </span>
                    </td>
                    </tr>
                    @endforeach --}}

                    <tr class="border-b hover:bg-gray-50 bg-gray-100">
                        <form action="{{ route('class.event-create', $schedule->id) }}" method="POST">
                            @csrf
                            <td colspan="3" class="px-4 py-2">
                                <select name="event_id" class="w-full rounded-md border-gray-300 shadow-sm p-1.5 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('event_id') border-red-500 @enderror">
                                    <option value="">Select an event</option>
                                    @foreach(App\Models\Event::ongoingEvents()->get()->merge(App\Models\Event::upcomingEvents()->get()) as $event)
                                    <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                                    @endforeach
                                </select>
                                @error('event_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </td>
                            <td colspan="2" class="px-4 py-2">
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                                    Create Attendance
                                </button>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection