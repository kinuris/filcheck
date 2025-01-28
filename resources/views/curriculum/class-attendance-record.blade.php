@extends('layouts.teacher')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 w-full">
    <div class="w-full bg-white shadow-lg">
        <div class="container mx-auto h-20 px-6 flex items-center">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo" class="h-12">
        </div>
    </div>

    <div class="container mx-auto px-6 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $class->subject->name }}</h1>
            <p class="text-gray-600">Location: {{ $class->room->name }} - {{ $class->room->building }}</p>

            <form class="mt-6">
                <div class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label for="specific_class_day" class="block text-gray-700 text-sm font-semibold mb-2">Select Date:</label>
                        <input type="date" id="specific_class_day" name="specific_class_day" 
                            value="{{ request('specific_class_day') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200 ease-in-out">
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Student ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Full Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Level</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Section</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
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
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->student_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->fullname }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $student->year }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $student->section }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log ? $log->day : 'ABSENT' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $log ? \Carbon\Carbon::parse($log->time)->format('h:i A') : 'ABSENT' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $log ? ($log->type == 'IN' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 'bg-red-100 text-red-800' }}">
                                {{ $log ? $log->type : 'ABSENT' }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection