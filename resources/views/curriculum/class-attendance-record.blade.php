@extends('layouts.teacher')

@section('content')
<div class="bg-gradient-to-b from-blue-500 to-blue-400 w-full">
    <div class="w-full inline-block bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
    </div>

    <div class="px-8 py-4">
        <h1 class="text-2xl font-bold text-white stroke-black stroke-1">CLASS: {{ $class->subject->name }}</h1>
        <p class="text-white text-sm">AT: {{ $class->room->name }} / {{ $class->room->building }}</p>

        <form>
            <div class="my-4">
                <label for="specific_class_day" class="block text-white text-sm font-bold mb-2">Specific Class Day:</label>
                <input type="date" id="specific_class_day" name="specific_class_day" value="{{ request('specific_class_day') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Filter
                </button>
            </div>
        </form>  

        <table class="min-w-full bg-blue-300 rounded-lg mt-8">
            <thead>
                <tr class="text-left">
                    <th class="py-2 px-4 border-b">STUDENT ID</th>
                    <th class="py-2 px-4 border-b">FULL NAME</th>
                    <th class="py-2 px-4 border-b">LEVEL</th>
                    <th class="py-2 px-4 border-b">SECTION</th>
                    <th class="py-2 px-4 border-b">DATE</th>
                    <th class="py-2 px-4 border-b">TIME</th>
                    <th class="py-2 px-4 border-b">TYPE</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                @php
                    $query = App\Models\ScheduleAttendanceRecord::query()
                        ->where('student_info_id', $student->id)
                        ->where('room_schedule_id', $class->id)
                        ->latest();

                    if (request('specific_class_day')) {
                        $query->where('day', '=', request('specific_class_day'));
                    }

                    $log = $query->first();
                @endphp
                <tr>
                    <td class="py-2 px-4 {{ $loop->last ? '' : 'border-b' }}">{{ $student->id }}</td>
                    <td class="py-2 px-4 {{ $loop->last ? '' : 'border-b' }}">{{ $student->fullname }}</td>
                    <td class="py-2 px-4 {{ $loop->last ? '' : 'border-b' }}">{{ $student->year }}</td>
                    <td class="py-2 px-4 {{ $loop->last ? '' : 'border-b' }}">{{ $student->section }}</td>
                    <td class="py-2 px-4 {{ $loop->last ? '' : 'border-b' }}">{{ $log ? $log->day : 'ABSENT' }}</td>
                    <td class="py-2 px-4 {{ $loop->last ? '' : 'border-b' }}">{{ $log ? \Carbon\Carbon::parse($log->time)->format('h:i A') : 'ABSENT' }}</td>
                    <td class="py-2 px-4 {{ $loop->last ? '' : 'border-b' }}">
                        <span class="{{ $log ? ($log->type == 'IN' ? 'text-green-600' : 'text-red-600') : 'text-red-600' }} font-bold">{{ $log ? $log->type : 'ABSENT' }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection