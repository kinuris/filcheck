@extends('layouts.teacher')

@section('title', 'Attendance')

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
                                    placeholder="Enter time threshold"
                                    value="{{ request()->query('late') == 1 ? old('time_threshold', request()->query('time_threshold')) : '' }}"
                                    required>
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
                                    placeholder="Enter time threshold"
                                    value="{{ request()->query('ontime') == 1 ? old('time_threshold', request()->query('time_threshold')) : '' }}"
                                    required>
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

<div class="w-full max-h-screen overflow-auto p-4 bg-gradient-to-b from-blue-600 via-blue-500 to-blue-400">
    <div class="mb-8 bg-gray-50 rounded-xl p-6 shadow-lg">
        <h1 class="text-4xl font-extrabold text-blue-900 mb-4 tracking-tight">{{ $event->name }}</h1>
        <div class="flex flex-wrap gap-4">
            <div
                class="flex-1 min-w-[250px] bg-gradient-to-br from-blue-600/90 to-blue-800/90 rounded-lg px-4 py-3 shadow-xl">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h2 class="text-lg font-semibold text-white">Start Date</h2>
                </div>
                <p class="mt-2 text-blue-100 font-medium">
                    {{ date_format($event->start, 'F d, Y') }}
                </p>
                <p class="text-blue-200 text-sm">
                    {{ date_format($event->start, 'g:i A') }}
                </p>
            </div>

            <div
                class="flex-1 min-w-[250px] bg-gradient-to-br from-sky-600/90 to-blue-600/90 rounded-lg px-4 py-3 shadow-xl">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-lg font-semibold text-white">End Date</h2>
                </div>
                <p class="mt-2 text-sky-100 font-medium">
                    {{ date_format($event->end, 'F d, Y') }}
                </p>
                <p class="text-sky-200 text-sm">
                    {{ date_format($event->end, 'g:i A') }}
                </p>
            </div>
        </div>

        <div class="mt-4">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Event Days</h2>
            <div class="grid grid-cols-2 sm:grid-cols-5 md:grid-cols-8 lg:grid-cols-10 gap-2">
                @for ($i = 1; $i <= $event->dayCount(); $i++)
                    @php
                    $dayDate = $event->start->copy()->addDays($i - 1);
                    $isCurrentDay = $dayDate->isSameDay(now());
                    @endphp
                    <div class="bg-white rounded-lg shadow-md p-2 border border-gray-200 
                {{ $isCurrentDay ? 'bg-gradient-to-r from-blue-500 to-blue-600 border-blue-600' : '' }}">
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

    <div class="flex justify-end mb-4 bg-gray-50 p-2 rounded-lg">
        @if (request()->query('day_count') || request()->query('time_threshold'))
        <div class="mr-auto bg-blue-100 text-blue-800 px-4 py-2 rounded-lg">
            @if (request()->query('day_count'))
            <span class="font-medium">Day {{ request()->query('day_count') }}</span>
            @endif
            @if (request()->query('time_threshold'))
            <span class="font-medium ml-2">
                Time: {{ \Carbon\Carbon::createFromFormat('H:i', request()->query('time_threshold'))->format('g:i A') }}
            </span>
            @endif
        </div>
        @endif

        <button onclick="document.getElementById('lateModal').classList.remove('hidden')"
            class="shadow bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mr-2">
            Late
        </button>
        <button onclick="document.getElementById('onTimeModal').classList.remove('hidden')"
            class="shadow bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
            On Time
        </button>
        <button onclick="document.getElementById('absentModal').classList.remove('hidden')" class="shadow bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Absent
        </button>
    </div>

    @if (request()->query('late') == 1)
    <div class="bg-orange-500 text-white text-center p-2 rounded mb-2">
        <p>Students are marked as late are <b></i>ORANGE</i></b>. Late if student entered after:
            {{ \Carbon\Carbon::createFromFormat('H:i', request()->query('time_threshold'))->format('g:i A') }}
        </p>
    </div>
    @endif

    @if (request()->query('ontime') == 1)
    <div class="bg-green-500 text-white text-center p-2 rounded mb-2">
        <p>Students are marked as on time are <b><i>GREEN</i></b>. On time if student entered before:
            {{ \Carbon\Carbon::createFromFormat('H:i', request()->query('time_threshold'))->format('g:i A') }}
        </p>
    </div>
    @endif

    <div class="mt-4">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <table class="w-full text-sm border-collapse">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">#</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Student ID</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Full Name</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Section</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Date</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Time</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-700">Type</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @if (empty($students))
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 bg-gray-50/50">
                            <p class="font-medium">No attendance records found</p>
                        </td>
                    </tr>
                    @endif
                    @foreach ($students as $index => $student)
                    @php
                    $day = $event->start->copy()->addDays((int) request()->query('day_count', 1) - 1)->startOfDay();
                    $latest = $student->attendanceRecordOf($event)->where('created_at', '>', $day->format('Y-m-d'))->where('created_at', '<', $day->addDays(1)->format('Y-m-d'))->orderBy('created_at', 'ASC')->get()->first();
                        $isLate = false;
                        if (request()->query('late') == 1 && $latest) {
                        $threshold = \Carbon\Carbon::createFromFormat('H:i', request()->query('time_threshold'));
                        $studentTime = \Carbon\Carbon::parse($latest->time);
                        $isLate = $studentTime->greaterThan($threshold);
                        }
                        @endphp

                        @php
                        $isOnTime = false;
                        if (request()->query('ontime') == 1 && $latest) {
                        $threshold = \Carbon\Carbon::createFromFormat('H:i', request()->query('time_threshold'));
                        $studentTime = \Carbon\Carbon::parse($latest->time);
                        $isOnTime = $studentTime->lessThan($threshold);
                        }
                        @endphp
                        <tr class="hover:bg-blue-50/50 transition-all duration-150 {{ $isLate ? 'bg-orange-200' : ($isOnTime ? 'bg-green-200' : '') }}">
                            <td class="px-6 py-4 text-gray-500 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium">{{ $student->id }}</td>
                            <td class="px-6 py-4">{{ $student->full_name }}</td>
                            <td class="px-6 py-4">{{ $student->section }}</td>
                            @if (is_null($latest))
                            <td class="px-6 py-4 text-gray-400 italic">Not recorded</td>
                            <td class="px-6 py-4 text-gray-400 italic">Not recorded</td>
                            <td class="px-6 py-4 text-gray-400 italic">Not recorded</td>
                            @else
                            <td class="px-6 py-4">{{ $latest->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 {{ $isLate ? 'text-orange-700 font-bold' : ($isOnTime ? 'text-green-700 font-bold' : '') }}">
                                {{ \Carbon\Carbon::parse($latest->time)->format('g:i A') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                            @if($latest->type == 'EXIT') bg-orange-100 text-orange-700
                                            @elseif($latest->type == 'ENTER') bg-green-100 text-green-700
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