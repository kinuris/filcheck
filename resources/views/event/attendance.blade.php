@extends('layouts.teacher')

@section('title', 'Attendance')

@section('content')
<!-- Late Modal -->
<div id="lateModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form>
                <input type="hidden" name="late" value="1">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Entering Time Threshold (Find Late Entrances)
                            </h3>
                            <div class="mt-2">
                                <label for="time_threshold" class="block text-sm font-medium text-gray-700">Late if Student Entered After</label>
                                <input type="time" name="time_threshold" id="time_threshold" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter time threshold" required>
                            </div>

                            <div class="mt-4">
                                <label for="day_count" class="block text-sm font-medium text-gray-700">Select Day</label>
                                <select id="day_count" name="day_count" class="border mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    @for ($i = 1; $i <= $event->dayCount(); $i++)
                                        <option value="{{ $i }}">Day {{ $i }}</option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" onclick="document.getElementById('lateModal').classList.add('hidden')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- On Time Modal -->
<div id="onTimeModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form>
                <input type="hidden" name="ontime" value="1">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Entering Time Threshold (On Time Entrances)
                            </h3>
                            <div class="mt-2">
                                <label for="time_threshold" class="block text-sm font-medium text-gray-700">On-time if Student Entered Before</label>
                                <input type="time" name="time_threshold" id="time_threshold" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter time threshold" required>
                            </div>

                            <div class="mt-4">
                                <label for="day_count" class="block text-sm font-medium text-gray-700">Select Day</label>
                                <select id="day_count" name="day_count" class="border mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    @for ($i = 1; $i <= $event->dayCount(); $i++)
                                        <option value="{{ $i }}">Day {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" onclick="document.getElementById('onTimeModal').classList.add('hidden')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="w-full p-4 bg-gradient-to-b from-blue-500 to-blue-400">
    <h1 class="text-3xl font-bold text-white">Event: <i>{{ $event->name }}</i></h1>
    <p class="text-sm mt-4 text-white">From: {{ date_format($event->start, 'M. d, Y g:i A') }}</p>
    <p class="text-sm mb-8 text-white">To: {{ date_format($event->end, 'M. d, Y g:i A') }}</p>

    <div class="flex justify-end mb-4 bg-white/60 p-2 rounded-lg">
        <button onclick="document.getElementById('lateModal').classList.remove('hidden')" class="shadow bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded mr-2">
            Late
        </button>
        <button onclick="document.getElementById('onTimeModal').classList.remove('hidden')" class="shadow bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
            On Time
        </button>
        <button class="shadow bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
            Absent
        </button>
    </div>

    @if(request()->query('late') == 1)
    <div class="bg-orange-500 text-white text-center p-2 rounded mb-4">
        <p>Some students are marked as late.</p>
    </div>
    @endif

    @if(request()->query('ontime') == 1)
    <div class="bg-green-500 text-white text-center p-2 rounded mb-4">
        <p>Students are marked as on time are GREEN. On Time If Student Entered Before: {{ \Carbon\Carbon::createFromFormat('H:i', request()->query('time_threshold'))->format('g:i A') }}</p>
    </div>
    @endif

    <table class="w-full bg-white rounded-lg shadow-lg">
        <thead class="bg-gray-200 text-left">
            <tr>
                <th class="rounded-tl-lg p-2">#</th>
                <th class="p-2">STUDENT ID</th>
                <th class="p-2">FULL NAME</th>
                <th class="p-2">SECTION</th>
                <th class="p-2">DATE</th>
                <th class="p-2">TIME</th>
                <th class="rounded-tr-lg p-2">TYPE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            @php($latest = $student->attendanceRecordOf($event)->latest()->first())
            @if (isset($records))
            @if (in_array($student->id, array_map(fn($e) => $e->student_info_id, $records)))
            @if(request()->query('late') == 1)
            <tr class="{{ $loop->last ? '' : 'border-b' }} text-left text-orange-500">
            @elseif(request()->query('ontime') == 1)
            <tr class="{{ $loop->last ? '' : 'border-b' }} text-left text-green-500">
            @else
            <tr class="{{ $loop->last ? '' : 'border-b' }} text-left">
            @endif
                <td class="p-2">{{ $index + 1 }}</td>
                <td class="p-2">{{ $student->id }}</td>
                <td class="p-2">{{ $student->full_name }}</td>
                <td class="p-2">{{ $student->section }}</td>
                @if (is_null($latest))
                <td class="p-2">(NONE)</td>
                <td class="p-2">(NONE)</td>
                <td class="p-2">(NONE)</td>
                @else
                <td class="p-2">{{ $latest->created_at }}</td>
                <td class="p-2">{{ $latest->time }}</td>
                <td class="p-2">{{ $latest->type }}</td>
                @endif
            </tr>
            @endif
            @else
            <tr class="{{ $loop->last ? '' : 'border-b' }} text-left">
                <td class="p-2">{{ $index + 1 }}</td>
                <td class="p-2">{{ $student->id }}</td>
                <td class="p-2">{{ $student->full_name }}</td>
                <td class="p-2">{{ $student->section }}</td>
                @if (is_null($latest))
                <td class="p-2">(NONE)</td>
                <td class="p-2">(NONE)</td>
                <td class="p-2">(NONE)</td>
                @else
                <td class="p-2">{{ $latest->created_at }}</td>
                <td class="p-2">{{ $latest->time }}</td>
                <td class="p-2">{{ $latest->type }}</td>
                @endif
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection