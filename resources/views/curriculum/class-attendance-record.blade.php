@extends('layouts.teacher')

@section('title', $class->subject->name . ' - ' . $class->room->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 w-full">
    <div class="w-full bg-white shadow-lg">
        <div class="container mx-auto h-16 px-6 flex items-center">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo" class="h-8">
        </div>
    </div>

    <div class="container mx-auto px-6 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $class->subject->name }}</h1>
            <p class="text-gray-600">Location: {{ $class->room->name }} - {{ $class->room->building }}</p>
            <div class="flex gap-2 mt-2">
                @foreach (json_decode($class->days_recurring) as $day)
                <div class="px-3 py-1 bg-blue-100 text-blue-700 rounded text-sm font-medium">
                    {{ $day }}
                </div>
                @endforeach
            </div>

            <form class="mt-6">
                <div class="flex gap-4 items-end">
                    <div class="flex-1">
                        @foreach (request()->except(['specific_class_day']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <label for="specific_class_day" class="block text-gray-700 text-sm font-semibold mb-2">Class
                            Calendar:</label>
                        <!-- <input type="date" id="specific_class_day" name="specific_class_day"
                                    value="{{ request('specific_class_day') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"> -->

                        <div class="relative">
                            <input type="text" id="specific_class_day" name="specific_class_day"
                                value="{{ request('specific_class_day') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg cursor-pointer" readonly>

                            <div id="calendar"
                                class="absolute top-full left-0 mt-2 bg-white border border-gray-200 rounded-lg shadow-xl hidden w-72 z-50">
                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <button type="button" id="prevMonth"
                                            class="p-2 rounded-full hover:bg-gray-100 transition-colors duration-200">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <span id="currentMonth" class="text-lg font-semibold text-gray-800"></span>
                                        <button type="button" id="nextMonth"
                                            class="p-2 rounded-full hover:bg-gray-100 transition-colors duration-200">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-7 gap-1 mb-2">
                                        <div class="text-center text-gray-600 font-medium text-xs p-1">Sun</div>
                                        <div class="text-center text-gray-600 font-medium text-xs p-1">Mon</div>
                                        <div class="text-center text-gray-600 font-medium text-xs p-1">Tue</div>
                                        <div class="text-center text-gray-600 font-medium text-xs p-1">Wed</div>
                                        <div class="text-center text-gray-600 font-medium text-xs p-1">Thu</div>
                                        <div class="text-center text-gray-600 font-medium text-xs p-1">Fri</div>
                                        <div class="text-center text-gray-600 font-medium text-xs p-1">Sat</div>
                                    </div>
                                    <div id="calendarDays" class="grid grid-cols-7 gap-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition duration-200 ease-in-out">
                        Apply Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <div class="flex items-center justify-between">
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <a href="?{{ http_build_query(array_merge(request()->query(), ['mode' => 'Reg'])) }}"
                        class="px-4 py-2 text-sm font-medium rounded-l-lg border border-blue-600
                {{ request('mode', 'Reg') === 'Reg' ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-50' }}
                transition-all duration-200">
                        Regular Students
                    </a>
                    <a href="?{{ http_build_query(array_merge(request()->query(), ['mode' => 'Irreg'])) }}"
                        class="px-4 py-2 text-sm font-medium rounded-r-lg border border-blue-600
                {{ request('mode') === 'Irreg' ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-50' }}
                transition-all duration-200">
                        Irregular Students
                    </a>
                </div>

                <div>
                    <span class="text-gray-700 mr-2">Attendance for:</span>
                    <span class="font-semibold text-blue-600">
                        {{ \Carbon\Carbon::parse(request('specific_class_day') ?? $class->lastClass()->format('Y-m-d'))->format('M. j, Y') }}
                    </span>
                </div>

                @php
                $currentDate = request('specific_class_day') ?? $class->lastClass()->format('Y-m-d');
                $holiday = App\Models\Holiday::where('date', $currentDate)->first();
                @endphp

                @if($holiday)
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 py-2 px-4 rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-2">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM8.547 9.547a.75.75 0 00-1.06 1.06l3.217 3.217H5.197a.75.75 0 000 1.5h5.504l-3.217 3.217a.75.75 0 101.06 1.06l4.5-4.5a.75.75 0 000-1.06l-4.5-4.5z" clip-rule="evenodd" />
                    </svg>
                    <span>Holiday: <b>{{ $holiday->name }}</b></span>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Student ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Full Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Level
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Section
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Entry Time
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($students as $student)
                    @php
                    if (request('mode') === 'Irreg') {
                    $query = App\Models\IrregularAttendanceRecord::query()
                    ->whereRelation('irregularRoomSchedule', 'student_info_id', '=', $student->id)
                    ->whereRelation('irregularRoomSchedule', 'room_schedule_id', '=', $class->id);
                    } else {
                    $query = App\Models\ScheduleAttendanceRecord::query()
                    ->where('student_info_id', $student->id)
                    ->where('room_schedule_id', $class->id);
                    }

                    if (request('specific_class_day')) {
                    $query = $query->where('day', '=', request('specific_class_day'));
                    } else {
                    $query = $query->where('day', '=', $class->lastClass()->format('Y-m-d'));
                    }

                    $fq = clone $query;

                    $log = $query->latest()
                    ->first();

                    $firstLog = $fq->orderBy('created_at', 'asc')
                    ->first();

                    @endphp

                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $student->student_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $student->fullname }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $student->year }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $student->section }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            <div class="flex">
                                <span>{{ $log ? $log->day : 'ABSENT' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $log ? \Carbon\Carbon::parse($firstLog->time)->format('h:i:s A') : 'ABSENT' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex">
                                @php
                                $isHoliday = false;
                                $holidayName = '';
                                $currentDate = request('specific_class_day') ?? $class->lastClass()->format('Y-m-d');
                                $holiday = App\Models\Holiday::where('date', $currentDate)->first();

                                if ($holiday) {
                                $isHoliday = true;
                                $holidayName = $holiday->name;
                                }
                                @endphp

                                @if($isHoliday)
                                <span class="px-2 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Holiday: {{ $holidayName }}
                                </span>
                                @else
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $log ? ($log->type == 'IN' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 'bg-red-100 text-red-800' }}">
                                    {{ $log ? $log->type : 'ABSENT' }}
                                </span>
                                @if($firstLog)
                                @php
                                $scheduledTime = \Carbon\Carbon::parse($class->start_time);
                                $logTime = \Carbon\Carbon::parse($firstLog->time);
                                $lateThreshold = $scheduledTime->copy()->addMinutes(15);
                                $isLate = $logTime->gt($lateThreshold);
                                @endphp

                                @if($isLate)
                                <span class="ml-2 px-2 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    LATE
                                    <span class="relative ml-1 group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="hidden text-justify group-hover:block absolute z-10 p-2 mt-1 text-xs bg-gray-800 text-white rounded shadow-lg right-0 bottom-full w-80 whitespace-normal overflow-y-auto max-h-32">
                                            <p class="indent-4">Students entering 15 minutes or later after the class schedule start time are marked as late.</p>
                                        </span>
                                    </span>
                                </span>
                                @endif
                                @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('specific_class_day');
        const calendar = document.getElementById('calendar');
        const currentMonthElement = document.getElementById('currentMonth');
        const calendarDays = document.getElementById('calendarDays');
        let currentDate = new Date();

        const daysRecurring = JSON.parse('<?php echo $class->days_recurring; ?>'); // ['Mon', 'Tue']

        const dayMapping = {
            'Sun': 0,
            'Mon': 1,
            'Tue': 2,
            'Wed': 3,
            'Thu': 4,
            'Fri': 5,
            'Sat': 6
        };

        input.addEventListener('click', () => {
            calendar.classList.toggle('hidden');
            renderCalendar();
        });

        document.getElementById('prevMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });

        <?php

        use App\Models\Holiday;

        $holidays = Holiday::all()->toArray();
        ?>

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const today = new Date();

            currentMonthElement.textContent =
                `${firstDay.toLocaleString('default', { month: 'long' })} ${year}`;

            calendarDays.innerHTML = '';

            for (let i = 0; i < firstDay.getDay(); i++) {
                calendarDays.appendChild(document.createElement('div'));
            }

            // Convert PHP holidays array to JavaScript
            const holidays = <?php echo json_encode($holidays); ?>;

            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dayElement = document.createElement('div');
                const date = new Date(year, month, day);
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const dayName = date.toLocaleString('en-US', {
                    weekday: 'short'
                });
                const isRecurringDay = daysRecurring.includes(dayName);
                const isFutureDate = date > today;

                // Check if the current date is a holiday
                const isHoliday = holidays.some(holiday => holiday.date === dateString);

                dayElement.textContent = day;

                let className = 'text-center py-1 cursor-pointer rounded';

                if (isFutureDate) {
                    className += ' text-gray-300';
                } else if (isHoliday) {
                    className += ' bg-red-200 text-red-700 font-semibold hover:bg-red-300';
                } else if (isRecurringDay) {
                    className += ' bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100';
                } else {
                    className += ' text-gray-400 hover:bg-gray-100';
                }

                dayElement.className = className;

                dayElement.addEventListener('click', () => {
                    if ((isRecurringDay || isHoliday) && !isFutureDate) {
                        input.value = dateString;
                        calendar.classList.add('hidden');
                    }
                });

                calendarDays.appendChild(dayElement);
            }
        }
    });
</script>
@endsection