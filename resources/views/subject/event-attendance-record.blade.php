@extends('layouts.teacher')

@section('title', $schedule->subject->name . ' - ' . $event->name)

@section('content')
<!-- Late Modal -->
<div id="lateModal" class="hidden fixed z-50 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-800 opacity-80"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200">
            <form>
                <input type="hidden" name="late" value="1">

                <!-- Header -->
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white" id="modal-title">
                        Late Attendance Settings
                    </h3>
                </div>

                <!-- Body -->
                <div class="bg-white px-6 py-5">
                    <div class="space-y-6">
                        <div>
                            <label for="time_threshold" class="block text-sm font-semibold text-gray-700 mb-2">
                                Time Threshold
                            </label>
                            <div class="relative">
                                <input type="time" name="time_threshold" id="time_threshold"
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-150"
                                    value="{{ request()->query('late') == 1 ? old('time_threshold', request()->query('time_threshold')) : '' }}"
                                    placeholder="Enter time threshold" required>
                                <div class="text-xs text-gray-500 mt-1">Students will be marked late after this time</div>
                            </div>
                        </div>

                        <div>
                            <label for="day_count" class="block text-sm font-semibold text-gray-700 mb-2">
                                Event Day
                            </label>
                            <select id="day_count" name="day_count"
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-150">
                                @for ($i = 1; $i <= $event->dayCount(); $i++)
                                    <option value="{{ $i }}" {{ request()->query('late') == 1 && request()->query('day_count') == $i ? 'selected' : '' }}>
                                        Day {{ $i }}
                                    </option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:gap-3">
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 bg-orange-500 text-white font-medium rounded-lg hover:bg-orange-600 focus:ring-4 focus:ring-orange-300 transition duration-150 text-sm">
                        Apply Settings
                    </button>
                    <button type="button"
                        class="mt-3 sm:mt-0 w-full sm:w-auto px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 transition duration-150 text-sm"
                        onclick="document.getElementById('lateModal').classList.add('hidden')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- On Time Modal -->
<div id="onTimeModal" class="hidden fixed z-50 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-800 opacity-80"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200">
            <form>
                <input type="hidden" name="ontime" value="1">

                <!-- Header -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white" id="modal-title">
                        On-Time Attendance Settings
                    </h3>
                </div>

                <!-- Body -->
                <div class="bg-white px-6 py-5">
                    <div class="space-y-6">
                        <div>
                            <label for="time_threshold" class="block text-sm font-semibold text-gray-700 mb-2">
                                Time Threshold
                            </label>
                            <div class="relative">
                                <input type="time" name="time_threshold" id="time_threshold"
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-150"
                                    placeholder="Enter time threshold" required
                                    value="{{ request()->query('ontime') == 1 ? old('time_threshold', request()->query('time_threshold')) : '' }}">
                                <div class="text-xs text-gray-500 mt-1">Students who enter before this time will be marked as on-time</div>
                            </div>
                        </div>

                        <div>
                            <label for="day_count" class="block text-sm font-semibold text-gray-700 mb-2">
                                Event Day
                            </label>
                            <select id="day_count" name="day_count"
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-150">
                                @for ($i = 1; $i <= $event->dayCount(); $i++)
                                    <option value="{{ $i }}" {{ request()->query('ontime') == 1 && request()->query('day_count') == $i ? 'selected' : '' }}>
                                        Day {{ $i }}
                                    </option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:gap-3">
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 focus:ring-4 focus:ring-green-300 transition duration-150 text-sm">
                        Apply Settings
                    </button>
                    <button type="button"
                        class="mt-3 sm:mt-0 w-full sm:w-auto px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 transition duration-150 text-sm"
                        onclick="document.getElementById('onTimeModal').classList.add('hidden')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Absent Modal -->
<div id="absentModal" class="hidden fixed z-50 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-800 opacity-80"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200">
            <form>
                <input type="hidden" name="absent" value="1">

                <!-- Header -->
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white" id="modal-title">
                        Absent Settings
                    </h3>
                </div>

                <!-- Body -->
                <div class="bg-white px-6 py-5">
                    <div class="space-y-6">
                        <div>
                            <label for="day_count" class="block text-sm font-semibold text-gray-700 mb-2">
                                Event Day
                            </label>
                            <select id="day_count" name="day_count"
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-150">
                                @for ($i = 1; $i <= $event->dayCount(); $i++)
                                    <option value="{{ $i }}">Day {{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:gap-3">
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-2.5 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 focus:ring-4 focus:ring-red-300 transition duration-150 text-sm">
                        Mark as Absent
                    </button>
                    <button type="button"
                        class="mt-3 sm:mt-0 w-full sm:w-auto px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 transition duration-150 text-sm"
                        onclick="document.getElementById('absentModal').classList.add('hidden')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@php($students = $schedule->eventAttendances()->get()->map(fn($ev) => $ev->student))
<div class="w-full p-6 bg-gradient-to-b from-blue-600 via-blue-500 to-blue-400">
    <div class="mb-8 bg-white rounded-xl p-8 shadow-xl border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $event->name }}</h1>
        <div class="flex flex-wrap gap-5 mb-6">
            <div class="flex-1 min-w-[280px] bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg px-5 py-4 shadow-xl">
                <div class="flex items-center space-x-3 mb-2">
                    <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h2 class="text-base font-medium text-white">Start Date</h2>
                </div>
                <p class="mt-1 text-blue-100 font-semibold text-lg">
                    {{ date_format($event->start, 'F d, Y') }}
                </p>
                <p class="text-blue-200 text-sm">
                    {{ date_format($event->start, 'g:i A') }}
                </p>
            </div>

            <div class="flex-1 min-w-[280px] bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg px-5 py-4 shadow-xl">
                <div class="flex items-center space-x-3 mb-2">
                    <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-base font-medium text-white">End Date</h2>
                </div>
                <p class="mt-1 text-blue-100 font-semibold text-lg">
                    {{ date_format($event->end, 'F d, Y') }}
                </p>
                <p class="text-blue-200 text-sm">
                    {{ date_format($event->end, 'g:i A') }}
                </p>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-bold text-gray-700 mb-3">Event Timeline</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-10 gap-2">
                @for ($i = 1; $i <= $event->dayCount(); $i++)
                   @php($dayDate = $event->start->copy()->addDays($i - 1))
                   @php($isCurrentDay = $dayDate->isSameDay(now()))
                    <div class="rounded-md shadow-sm p-2 border transition-all 
                        {{ $isCurrentDay ? 'bg-gradient-to-r from-blue-500 to-blue-600 border-blue-600' : 'bg-white border-gray-200 hover:border-blue-300 hover:shadow' }}">
                        <h3 class="text-sm font-semibold {{ $isCurrentDay ? 'text-white' : 'text-blue-800' }}">
                            Day {{ $i }}
                        </h3>
                        <p class="{{ $isCurrentDay ? 'text-blue-100' : 'text-gray-600' }} text-xs">
                            {{ $dayDate->format('M d') }}
                        </p>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-5 bg-white p-4 rounded-lg shadow-md">
        @if (request()->query('day_count') || request()->query('time_threshold'))
        <div class="bg-blue-50 text-blue-800 px-4 py-2 rounded-md border border-blue-200">
            <span class="font-medium">Filters:</span>
            @if (request()->query('day_count'))
            <span class="ml-2 font-medium">Day {{ request()->query('day_count') }}</span>
            @endif
            @if (request()->query('time_threshold'))
            <span class="ml-2">
                Time: {{ \Carbon\Carbon::createFromFormat('H:i', request()->query('time_threshold'))->format('g:i A') }}
            </span>
            @endif
        </div>
        @else
        <div></div>
        @endif

        <div class="flex gap-3">
            <button onclick="document.getElementById('onTimeModal').classList.remove('hidden')"
                class="shadow-sm bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                On Time
            </button>
            <button onclick="document.getElementById('lateModal').classList.remove('hidden')"
                class="shadow-sm bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Late
            </button>
            <button onclick="document.getElementById('absentModal').classList.remove('hidden')" 
                class="shadow-sm bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Absent
            </button>
        </div>
    </div>

    @if (request()->query('late') == 1 || request()->query('ontime') == 1)
    <div class="mb-5">
        @if (request()->query('late') == 1)
        <div class="bg-orange-500 bg-opacity-90 text-white text-center p-3 rounded-md shadow-md border border-orange-600">
            <div class="flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Students marked as <strong>late</strong> are highlighted in orange. Late threshold: 
                    <strong>{{ \Carbon\Carbon::createFromFormat('H:i', request()->query('time_threshold'))->format('g:i A') }}</strong>
                </p>
            </div>
        </div>
        @endif

        @if (request()->query('ontime') == 1)
        <div class="bg-green-600 bg-opacity-90 text-white text-center p-3 rounded-md shadow-md border border-green-700">
            <div class="flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p>Students marked as <strong>on time</strong> are highlighted in green. On time threshold: 
                    <strong>{{ \Carbon\Carbon::createFromFormat('H:i', request()->query('time_threshold'))->format('g:i A') }}</strong>
                </p>
            </div>
        </div>
        @endif
    </div>
    @endif

    <div class="mt-4">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-200">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">#</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Student ID</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Full Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Section</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Date</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Time</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Type</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @if (empty($students))
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500">No attendance records found</td>
                    </tr>
                    @endif
                    @foreach ($students as $index => $student)
                    @php($day = $event->start->copy()->addDays((int) request()->query('day_count', 1) - 1)->startOfDay())
                    @php($latest = $student->attendanceRecordOf($event)->where('created_at', '>', $day->format('Y-m-d'))->where('created_at', '<', $day->addDays(1)->format('Y-m-d'))->orderBy('created_at', 'ASC')->get()->first())
                    @php($isLate = request()->query('late') == 1 && $latest && \Carbon\Carbon::parse($latest->time)->format('H:i') > request()->query('time_threshold'))
                    @php($isOnTime = request()->query('ontime') == 1 && $latest && \Carbon\Carbon::parse($latest->time)->format('H:i') < request()->query('time_threshold'))

                    <tr class="hover:bg-blue-50/50 transition-all duration-200 
                        @if($isLate) bg-orange-50 hover:bg-orange-100/80 
                        @elseif($isOnTime) bg-green-50 hover:bg-green-100/80 
                        @endif">
                        <td class="px-4 py-3 text-gray-600 font-medium">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-3 font-mono text-blue-700 font-medium">{{ $student->id }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $student->full_name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $student->section }}</td>
                        @if (is_null($latest))
                        <td colspan="3" class="px-4 py-3 text-center">
                            <span class="text-gray-500 bg-gray-100 px-3 py-1 rounded-full text-xs font-medium">No Record</span>
                        </td>
                        @else
                        <td class="px-4 py-3 text-gray-600">{{ $latest->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 font-medium 
                            @if($isLate) text-orange-700 
                            @elseif($isOnTime) text-green-700 
                            @else text-gray-800 @endif">
                            {{ \Carbon\Carbon::parse($latest->time)->format('g:i A') }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($latest->type == 'ENTER') bg-green-100 text-green-700
                            @elseif($latest->type == 'EXIT') bg-orange-100 text-orange-700
                            @endif">
                                {{ $latest->type }}
                            </span>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection