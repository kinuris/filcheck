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

            <div class="flex items-center space-x-4 mb-8 bg-white p-4 rounded-lg shadow-lg">
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <a href="?{{ http_build_query(array_merge(request()->query(), ['mode' => 'Reg'])) }}"
                        class="px-8 py-3 text-sm font-medium rounded-l-lg border border-blue-600
            {{ request('mode', 'Reg') === 'Reg' ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-50' }}
            transition-all duration-200">
                        Regular Students
                    </a>
                    <a href="?{{ http_build_query(array_merge(request()->query(), ['mode' => 'Irreg'])) }}"
                        class="px-8 py-3 text-sm font-medium rounded-r-lg border border-blue-600
            {{ request('mode') === 'Irreg' ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 hover:bg-blue-50' }}
            transition-all duration-200">
                        Irregular Students
                    </a>
                </div>

                <p>You are looking at day: </p>
                <span class="ml-2 font-semibold text-blue-600">
                    {{ \Carbon\Carbon::parse(request('specific_class_day') ?? $class->lastClass()->format('Y-m-d'))->format('M. j, Y') }}
                </span>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Student ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Full Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Level</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Section</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Time</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($students as $student)
                            @php
                                if (request('mode') === 'Irreg') {
                                    $query = App\Models\IrregularAttendanceRecord::query()
                                        ->whereRelation('irregularRoomSchedule', 'student_info_id', '=', $student->id)
                                        ->whereRelation('irregularRoomSchedule', 'room_schedule_id', '=', $class->id)
                                        ->latest();
                                } else {
                                    $query = App\Models\ScheduleAttendanceRecord::query()
                                        ->where('student_info_id', $student->id)
                                        ->where('room_schedule_id', $class->id)
                                        ->latest();
                                }

                                if (request('specific_class_day')) {
                                    $query = $query->where('day', '=', request('specific_class_day'));
                                } else {
                                    $query = $query->where('day', '=', $class->lastClass()->format('Y-m-d'));
                                }

                                $log = $query->first();
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $student->student_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $student->fullname }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $student->year }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $student->section }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $log ? $log->day : 'ABSENT' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $log ? \Carbon\Carbon::parse($log->time)->format('h:i A') : 'ABSENT' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
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

                for (let day = 1; day <= lastDay.getDate(); day++) {
                    const dayElement = document.createElement('div');
                    const date = new Date(year, month, day);
                    const dayName = date.toLocaleString('en-US', {
                        weekday: 'short'
                    });
                    const isRecurringDay = daysRecurring.includes(dayName);
                    const isFutureDate = date > today;

                    dayElement.textContent = day;
                    dayElement.className = `text-center py-1 cursor-pointer rounded ${
                                        isFutureDate 
                                            ? 'text-gray-300' 
                                            : isRecurringDay 
                                                ? 'bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100' 
                                                : 'text-gray-400 hover:bg-gray-100'
                                    }`;

                    dayElement.addEventListener('click', () => {
                        if (isRecurringDay && !isFutureDate) {
                            input.value =
                                `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                            calendar.classList.add('hidden');
                        }
                    });
                    calendarDays.appendChild(dayElement);
                }
            }
        });
    </script>
@endsection
