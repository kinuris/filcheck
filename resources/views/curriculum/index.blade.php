@extends('layouts.admin')

@section('content')
<!-- Setup Schedule Modal -->
<div id="setupScheduleModal" class="hidden z-50 fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-lg shadow-xl p-8 w-1/3 min-w-[500px] border-t-4 border-blue-500">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <span class="material-symbols-outlined text-blue-600 mr-2">event_available</span>
                Setup Class Schedule
            </h2>
            <button onclick="toggleModal('setupScheduleModal')" class="text-gray-500 hover:text-gray-700 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('room-schedule.create') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="room_id" class="block text-sm font-medium text-gray-700 mb-1">Room Assignment</label>
                    <input type="text" id="room_name" name="room_name"
                        class="w-full border border-gray-300 rounded-md px-3 py-2.5 bg-gray-50 text-gray-800 font-medium"
                        value="{{ old('room_name') }}" readonly>
                    <input type="hidden" name="room_id" id="room_id" value="{{ old('room_id') }}">
                </div>
                <div>
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <input type="text" id="subject_name" name="subject_name"
                        class="w-full border border-gray-300 rounded-md px-3 py-2.5 bg-gray-50 text-gray-800 font-medium"
                        value="{{ old('subject_name') }}" readonly>
                    <input type="hidden" name="subject_id" id="subject_id" value="{{ old('subject_id') }}">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Meeting Days</label>
                <div class="grid grid-cols-6 gap-4">
                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="relative flex items-center">
                        <input type="checkbox" id="day-{{ $day }}" name="days[]" value="{{ $day }}"
                            class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300"
                            {{ in_array($day, old('days', [])) ? 'checked' : '' }}>
                        <label for="day-{{ $day }}" class="ml-2 text-sm text-gray-700">{{ $day }}</label>
                    </div>
                    @endforeach
                </div>
                @error('days')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                        </span>
                        <input type="time" name="start_time" id="start_time"
                            class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2.5"
                            value="{{ old('start_time') }}">
                    </div>
                    @error('start_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                        </span>
                        <input type="time" name="end_time" id="end_time"
                            class="w-full border border-gray-300 rounded-md pl-10 pr-3 py-2.5"
                            value="{{ old('end_time') }}">
                    </div>
                    @error('end_time')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Teacher Assignment</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500" style="z-index: 11;">
                        <span class="material-symbols-outlined text-sm">person</span>
                    </span>
                    <select name="teacher_id" id="teacher_id"
                        class="teacher-select w-full border border-gray-300 rounded-md pl-10 pr-3 py-2.5 appearance-none bg-white" style="display: none;">
                        <option value="" disabled {{ old('teacher_id') ? '' : 'selected' }}>Select a teacher</option>
                        @foreach(App\Models\User::where('role', 'teacher')->get() as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->getFullname() }}
                        </option>
                        @endforeach
                    </select>
                    <!-- Teacher Search Input will be inserted here by JS -->
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500" style="z-index: 11;">
                        <span class="material-symbols-outlined">arrow_drop_down</span>
                    </span>
                </div>
                @error('teacher_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            <div>
                <label for="section_id" class="block text-sm font-medium text-gray-700 mb-1">Student Section</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500" style="z-index: 11;">
                        <span class="material-symbols-outlined text-sm">group</span>
                    </span>

                    <select name="section" id="section_id"
                        class="section-select w-full border border-gray-300 rounded-md pl-10 pr-3 py-2.5 appearance-none bg-white" style="display: none;">
                        <option value="" disabled {{ old('section') ? '' : 'selected' }}>Select a section</option>
                        @foreach(App\Models\StudentInfo::whereDoesntHave('disabledRelation')->distinct('section')->pluck('section') as $section)
                        <option value="{{ $section }}" {{ old('section') == $section ? 'selected' : '' }}>
                            @php
                            $sectionParts = explode('-', $section);
                            $year = $sectionParts[0] ?? '';
                            $sectionNum = isset($sectionParts[1]) ? (int)filter_var($sectionParts[1], FILTER_SANITIZE_NUMBER_INT) : null;
                            $suffix = match($sectionNum) {
                                1 => 'st',
                                2 => 'nd',
                                3 => 'rd',
                                default => 'th'
                            };
                            $displayYear = $sectionNum ? "({$sectionNum}{$suffix} year)" : '';
                            @endphp
                            {{ $displayYear }} {{ $section }}
                        </option>
                        @endforeach
                    </select>
                    <div class="section-search-wrapper relative">
                        <input type="text" id="section_search"
                            placeholder="Search for a section..."
                            class="w-full border border-gray-300 rounded-md pl-10 pr-8 py-2.5"
                            autocomplete="off"
                            value="{{ old('section') ? (App\Models\StudentInfo::where('section', old('section'))->exists() ? App\Models\StudentInfo::where('section', old('section'))->first()->section : '') : '' }}">
                        <button type="button" class="clear-section-search absolute right-10 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600" style="display: none;">&times;</button>
                        <div class="section-dropdown absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-60 overflow-y-auto hidden"></div>
                    </div>

                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500" style="z-index: 11;">
                        <span class="material-symbols-outlined">arrow_drop_down</span>
                    </span>
                </div>
                @error('section')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end mt-8 pt-4 border-t border-gray-200">
                <button type="button" onclick="toggleModal('setupScheduleModal')"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-3 hover:bg-gray-300 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors flex items-center">
                    <span class="material-symbols-outlined mr-1">save</span>
                    Save Schedule
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Conflict Error Modal -->
<div id="conflictErrorModal" class="hidden z-50 fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-lg shadow-xl p-8 w-1/3 min-w-[600px] border-t-4 border-red-600">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <span class="material-symbols-outlined text-red-600 mr-2">error</span>
                Schedule Conflict Detected
            </h2>
            <button onclick="toggleModal('conflictErrorModal')" class="text-gray-500 hover:text-gray-700 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        @if ($errors->has('conflict'))
        @php($schedule = App\Models\RoomSchedule::find(session('conflicting_schedule')))
        <div class="bg-red-50 border-l-4 border-red-500 text-gray-800 p-5 rounded-md mb-4">
            <p class="font-semibold text-lg mb-4">This schedule conflicts with an existing reservation:</p>
            <div class="space-y-3 pl-2">
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-gray-500 mr-3">meeting_room</span>
                    <p><span class="font-medium text-gray-700">Room:</span> {{ $schedule->room->name }}</p>
                </div>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-gray-500 mr-3">menu_book</span>
                    <p><span class="font-medium text-gray-700">Subject:</span> {{ $schedule->subject->name }}</p>
                </div>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-gray-500 mr-3">schedule</span>
                    <p><span class="font-medium text-gray-700">Time:</span> {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</p>
                </div>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-gray-500 mr-3">calendar_today</span>
                    <p><span class="font-medium text-gray-700">Days:</span> {{ implode(', ', json_decode($schedule->days_recurring)) }}</p>
                </div>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-gray-500 mr-3">person</span>
                    <p><span class="font-medium text-gray-700">Teacher:</span> {{ $schedule->teacher->getFullname() }}</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
            <button type="button" onclick="toggleModal('conflictErrorModal');"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-3 hover:bg-gray-300 transition-colors">
                Cancel
            </button>
            <button type="button" onclick="toggleModal('conflictErrorModal'); toggleModal('setupScheduleModal');"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition-colors flex items-center">
                <span class="material-symbols-outlined mr-1">edit</span>
                Modify Schedule
            </button>
        </div>
        @endif
    </div>
</div>

<script>
    <?php if ($errors->has('conflict')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            toggleModal('conflictErrorModal');
        });
    <?php endif; ?>
</script>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>

<div class="min-h-screen max-h-[calc(100vh-4em)] bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 min-w-[calc(100vw-300px)] overflow-auto">
    <!-- Header -->
    <div class="w-full bg-white shadow-lg">
        <div class="container mx-auto h-16 p-4 flex items-center justify-between">
            <div class="flex items-center">
                <img src="{{ asset('assets/filcheck.png') }}" alt="FilCheck Logo" class="h-8">
                <span class="ml-3 text-gray-700 font-semibold text-lg">|</span>
                <span class="ml-3 text-gray-700 font-semibold text-lg">Academic Programs</span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500">{{ date('F j, Y') }}</span>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-8 py-6">
        <!-- Title Section -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white tracking-tight">Academic Programs Management</h1>
        </div>

        <!-- Rooms Management Section -->
        @php($rooms = App\Models\Room::all())
        <div class="bg-white rounded-xl p-6 mb-6 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-4">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">meeting_room</span>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Room Management</h2>
                        <p class="text-sm text-gray-500">{{ count($rooms) }} rooms available for scheduling</p>
                    </div>
                </div>
                <a href="{{ route('room.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-all duration-300 flex items-center group">
                    <span class="material-symbols-outlined mr-2 text-sm group-hover:scale-110 transition-transform">add_circle</span>
                    Add Room
                </a>
            </div>

            <div class="overflow-x-auto">
                <div class="flex space-x-4 py-3">
                    @if (count($rooms) === 0)
                    <div class="w-full text-center py-8 bg-gray-50 rounded-lg">
                        <span class="material-symbols-outlined text-gray-400 text-4xl mb-2">inventory_2</span>
                        <p class="text-gray-500 font-medium">No Rooms Available</p>
                        <p class="text-gray-400 text-sm mt-1">Add rooms to begin scheduling classes</p>
                    </div>
                    @endif
                    @foreach($rooms as $room)
                    <div data-room-name="{{ $room->name }}"
                        data-room-id="{{ $room->id }}"
                        class="bg-white rounded-lg border border-gray-200 px-5 py-4 w-72 shadow-sm hover:shadow-md
                        cursor-move draggable transform hover:-translate-y-1 transition-all duration-300"
                        draggable="true"
                        ondragstart="event.dataTransfer.setData('text/plain', '{{ $room->id }}')">
                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $room->name }}</h3>
                                <span class="inline-block bg-blue-50 text-blue-600 text-xs px-2 py-0.5 rounded-md font-medium">ID: {{ $room->id }}</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <a href="{{ route('room.edit', $room->id) }}" class="p-1.5 hover:bg-gray-100 rounded-full transition-colors duration-300">
                                    <span class="material-symbols-outlined text-blue-600 text-sm">edit</span>
                                </a>
                                <form action="{{ route('room.delete', ['room' => $room->id]) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this room? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 hover:bg-gray-100 rounded-full transition-colors duration-300">
                                        <span class="material-symbols-outlined text-red-500 text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-700 bg-gray-50 p-2 rounded-md mb-3">
                            <span class="material-symbols-outlined text-gray-500 text-sm">location_on</span>
                            <p class="font-medium text-sm">{{ $room->building }}</p>
                        </div>
                        <div class="flex items-center text-xs text-gray-500 border-t border-gray-100 pt-2">
                            <span class="material-symbols-outlined mr-1 text-gray-400 text-sm">drag_indicator</span>
                            <p>Drag to assign to a subject</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-blue-600 bg-opacity-20 backdrop-blur-sm rounded-lg p-3 mb-6 flex items-center justify-center space-x-3 border border-white border-opacity-20">
            <span class="material-symbols-outlined text-white">info</span>
            <p class="text-white text-sm font-medium">Drag a Room to a Subject to Create a Schedule</p>
        </div>

        <!-- Subjects Section -->
        @php($subjects = App\Models\Subject::all())
        <div class="bg-white rounded-xl p-6 mb-6 shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center space-x-4">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">menu_book</span>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Subjects Management</h2>
                        <p class="text-sm text-gray-500">{{ count($subjects) }} subjects available for assignment</p>
                    </div>
                </div>
                <a href="{{ route('subject.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow-md transition-all duration-300 flex items-center group">
                    <span class="material-symbols-outlined mr-2 text-sm group-hover:scale-110 transition-transform">add_circle</span>
                    Add Subject
                </a>
            </div>

            <div class="overflow-x-auto">
                <div class="flex space-x-4 py-3">
                    @if (count($subjects) === 0)
                    <div class="w-full text-center py-8 bg-gray-50 rounded-lg">
                        <span class="material-symbols-outlined text-gray-400 text-4xl mb-2">menu_book</span>
                        <p class="text-gray-500 font-medium">No Subjects Available</p>
                        <p class="text-gray-400 text-sm mt-1">Add subjects to begin creating schedules</p>
                    </div>
                    @endif
                    @foreach($subjects as $subject)
                    <div data-subject-name="{{ $subject->name }}"
                        data-subject-id="{{ $subject->id }}"
                        class="bg-white rounded-lg border border-gray-200 px-5 py-4 w-72 shadow-sm hover:shadow-md transition-all duration-300 relative group"
                        ondragover="event.preventDefault(); this.classList.add('bg-blue-100', 'border-blue-400', 'scale-105', 'shadow-lg');"
                        ondragleave="this.classList.remove('bg-blue-100', 'border-blue-400', 'scale-105', 'shadow-lg');"
                        ondrop="onDropRoom(event, this); this.classList.remove('bg-blue-100', 'border-blue-400', 'scale-105', 'shadow-lg');">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h2 class="text-xl font-bold text-gray-800">{{ $subject->name }}</h2>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="material-symbols-outlined text-gray-400 text-xs">tag</span>
                                    <p class="id-tag hidden text-sm text-gray-600 font-medium">{{ $subject->id }}</p>
                                    <p class="text-sm text-gray-600 font-medium">{{ $subject->code }}</p>
                                </div>
                            </div>
                            <span class="bg-blue-50 text-blue-600 text-xs px-2 py-0.5 rounded-md font-medium">ID: {{ $subject->id }}</span>
                        </div>
                        <div class="flex justify-between items-center mt-3 pt-2 border-t border-gray-100">
                            <div class="flex items-center text-xs text-gray-500">
                                <span class="material-symbols-outlined mr-1 text-gray-400 text-sm">drag_indicator</span>
                                <p>Drop room here to schedule</p>
                            </div>
                            <div class="flex items-center space-x-1">
                                <a href="/subject/edit/{{ $subject->id }}" class="p-1.5 hover:bg-gray-100 rounded-full transition-colors duration-300">
                                    <span class="material-symbols-outlined text-blue-600 text-sm">edit</span>
                                </a>
                                <form action="{{ route('subject.delete', ['subject' => $subject->id]) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this subject? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 hover:bg-gray-100 rounded-full transition-colors duration-300">
                                        <span class="material-symbols-outlined text-red-500 text-sm">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Schedules Section -->
        @php($schedules = App\Models\RoomSchedule::all())
        <div class="bg-white rounded-xl p-6 shadow-lg mb-6">
            <div class="flex items-center mb-6">
                <span class="material-symbols-outlined text-blue-600 text-2xl mr-4">event</span>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Current Schedule Overview</h2>
                    <p class="text-sm text-gray-500">{{ count($schedules) }} active class schedules</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="flex space-x-4 py-3">
                    @if(count($schedules) === 0)
                    <div class="w-full text-center py-8 bg-gray-50 rounded-lg">
                        <span class="material-symbols-outlined text-gray-400 text-4xl mb-2">calendar_month</span>
                        <p class="text-gray-500 font-medium">No Schedules Available</p>
                        <p class="text-gray-400 text-sm mt-1">Drag a room to a subject to create a schedule</p>
                    </div>
                    @endif
                    @foreach($schedules as $schedule)
                    <div class="bg-white rounded-lg border border-gray-200 w-80 shadow-sm hover:shadow-md overflow-hidden transition-all duration-300">
                        <div class="p-3 bg-gradient-to-r from-blue-600 to-blue-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <h3 class="text-lg font-bold text-white">{{ $schedule->room->name }}</h3>
                                    <span class="bg-white bg-opacity-20 text-white text-xs px-2 py-0.5 rounded-md ml-3">{{ $schedule->room->building }}</span>
                                </div>
                                <a href="{{ route('irregular.index', $schedule->id) }}"
                                   class="p-1.5 bg-white bg-opacity-20 text-white rounded-md hover:bg-opacity-30 flex items-center justify-center group relative">
                                    <span class="material-symbols-outlined text-[16px]">add_task</span>
                                    <span class="absolute hidden group-hover:block right-0 bg-gray-900 text-white text-xs px-2 py-1 rounded shadow-lg -bottom-9 whitespace-nowrap z-10 font-medium">
                                        Add Irregular Student
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div class="px-4 py-3 space-y-3">
                            <div class="flex flex-col">
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-800 font-semibold">{{ $schedule->subject->name }}</p>
                                    <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded-md text-xs font-medium">{{ $schedule->subject->code }}</span>
                                </div>
                            </div>

                            <div class="space-y-2 text-sm">
                                <div class="flex flex-wrap gap-1">
                                    <div class="flex items-center text-gray-600">
                                        <span class="material-symbols-outlined mr-1 text-sm">calendar_today</span>
                                    </div>
                                    @foreach(json_decode($schedule->days_recurring) as $day)
                                    <span class="bg-blue-50 text-blue-600 text-xs px-2 py-0.5 rounded-md">{{ $day }}</span>
                                    @endforeach
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <span class="material-symbols-outlined mr-1 text-sm">schedule</span>
                                    <p class="font-medium text-sm">{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</p>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <span class="material-symbols-outlined mr-1 text-sm">group</span>
                                    <p class="font-medium text-sm">Section: {{ $schedule->section }}</p>
                                </div>
                            </div>

                            <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                                <div class="flex items-center space-x-1">
                                    <span class="material-symbols-outlined text-gray-500 text-sm">person</span>
                                    <p class="text-gray-700 text-sm font-medium">{{ $schedule->teacher->getFullname() }}</p>
                                </div>
                                <div class="flex space-x-1">
                                    <!-- <a href="" class="p-1.5 hover:bg-blue-50 rounded-full text-blue-600 transition-colors duration-300">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </a> -->
                                    <form action="{{ route('room-schedule.delete', ['roomSchedule' => $schedule->id]) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 hover:bg-red-50 rounded-full text-red-500 transition-colors duration-300">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sectionSelect = document.getElementById('section_id');
        const sections = Array.from(sectionSelect.options).map(option => ({
            value: option.value,
            text: option.text,
            selected: option.selected
        }));

        const searchInput = document.getElementById('section_search');
        const dropdown = document.querySelector('.section-dropdown');
        const clearButton = document.querySelector('.clear-section-search');
        const searchWrapper = document.querySelector('.section-search-wrapper');

        // Function to get display text for a section value
        function getSectionDisplayText(value) {
            const found = sections.find(s => s.value === value);
            return found ? found.text : value; // Fallback to value if not found
        }

        // Set initial value if there's an old value or selected option
        const initialValue = searchInput.value;
        if (initialValue) {
            searchInput.value = getSectionDisplayText(initialValue);
            clearButton.style.display = 'block';
        } else {
            const selectedOption = sections.find(s => s.selected && s.value);
            if (selectedOption) {
                searchInput.value = selectedOption.text;
                clearButton.style.display = 'block';
            }
        }

        // Search functionality
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const filtered = sections.filter(s =>
                s.text.toLowerCase().includes(query) && s.value !== '');

            renderDropdown(filtered);
            dropdown.classList.remove('hidden');
            clearButton.style.display = this.value ? 'block' : 'none';
        });

        searchInput.addEventListener('focus', function() {
            // Show all options on focus if input is empty or just clicked
            const query = this.value.toLowerCase();
            const filtered = sections.filter(s =>
                s.text.toLowerCase().includes(query) && s.value !== '');
            renderDropdown(filtered.length > 0 ? filtered : sections.filter(s => s.value !== ''));
            if (sections.length > 1) { // Only show if there are actual options
                 dropdown.classList.remove('hidden');
            }
        });

        document.addEventListener('click', function(e) {
            if (!searchWrapper.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Clear button functionality
        clearButton.addEventListener('click', function() {
            searchInput.value = '';
            sectionSelect.value = ''; // Clear the hidden select value
            dropdown.classList.add('hidden');
            clearButton.style.display = 'none';
            searchInput.focus(); // Keep focus for potentially new search
        });

        // Render dropdown items
        function renderDropdown(items) {
            dropdown.innerHTML = '';

            if (items.length === 0) {
                const noResults = document.createElement('div');
                noResults.className = 'px-4 py-2 text-sm text-gray-500';
                noResults.textContent = 'No sections found';
                dropdown.appendChild(noResults);
                return;
            }

            items.forEach(item => {
                const option = document.createElement('div');
                option.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                option.textContent = item.text;
                option.dataset.value = item.value;

                option.addEventListener('click', function() {
                    sectionSelect.value = this.dataset.value; // Set the hidden select value
                    searchInput.value = this.textContent; // Set the visible input text
                    dropdown.classList.add('hidden');
                    clearButton.style.display = 'block';
                });

                dropdown.appendChild(option);
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const teacherSelect = document.getElementById('teacher_id');
        const teachers = Array.from(teacherSelect.options)
            .filter(option => option.value !== '') // Exclude the placeholder/disabled option
            .map(option => ({
                value: option.value,
                text: option.text.trim() // Trim whitespace
            }));

        // Sort teachers alphabetically by text (full name)
        teachers.sort((a, b) => a.text.localeCompare(b.text));

        // Create wrapper for the search input and dropdown
        const searchWrapper = document.createElement('div');
        searchWrapper.className = 'relative teacher-search-wrapper'; // Added class for easier targeting

        // Create the search input field
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.id = 'teacher_search'; // Added ID for potential future use
        searchInput.placeholder = 'Search or select a teacher...';
        searchInput.className = 'w-full border border-gray-300 rounded-md pl-10 pr-8 py-2.5'; // Adjusted padding for icon
        searchInput.autocomplete = 'off';

        // Set the initial value in the search input if a teacher was selected (e.g., from old input)
        const selectedOption = teacherSelect.options[teacherSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            searchInput.value = selectedOption.text.trim();
        }

        // Insert the search wrapper before the original select (which is hidden)
        teacherSelect.parentNode.insertBefore(searchWrapper, teacherSelect);
        searchWrapper.appendChild(searchInput);
        // Keep the original select hidden: teacherSelect.style.display = 'none';

        // Create the dropdown container
        const dropdown = document.createElement('div');
        dropdown.className = 'teacher-dropdown absolute z-20 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-60 overflow-y-auto hidden shadow-lg'; // Added z-index and shadow
        searchWrapper.appendChild(dropdown);

        // Create and append the clear button
        const clearButton = document.createElement('button');
        clearButton.type = 'button';
        clearButton.className = 'clear-teacher-search absolute right-10 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600';
        clearButton.innerHTML = '&times;';
        clearButton.style.display = searchInput.value ? 'block' : 'none'; // Show if there's initial value
        searchWrapper.appendChild(clearButton);

        // Function to render dropdown items
        function renderDropdown(items) {
            dropdown.innerHTML = ''; // Clear previous items

            if (items.length === 0) {
                const noResults = document.createElement('div');
                noResults.className = 'px-4 py-2 text-sm text-gray-500';
                noResults.textContent = 'No teachers found';
                dropdown.appendChild(noResults);
                return;
            }

            items.forEach(item => {
                const option = document.createElement('div');
                option.className = 'px-4 py-2 hover:bg-blue-50 cursor-pointer text-sm'; // Adjusted hover style
                option.textContent = item.text;
                option.dataset.value = item.value;

                option.addEventListener('click', function() {
                    teacherSelect.value = this.dataset.value; // Update hidden select
                    searchInput.value = this.textContent;    // Update search input display
                    dropdown.classList.add('hidden');       // Hide dropdown
                    clearButton.style.display = 'block';    // Show clear button
                });

                dropdown.appendChild(option);
            });
        }

        // Event listener for input/typing in the search field
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const filtered = teachers.filter(t =>
                t.text.toLowerCase().includes(query)
            );
            renderDropdown(filtered);
            dropdown.classList.remove('hidden'); // Show dropdown with filtered results
            clearButton.style.display = this.value ? 'block' : 'none'; // Toggle clear button
        });

        // Event listener for focusing on the search field
        searchInput.addEventListener('focus', function() {
            const query = this.value.toLowerCase().trim();
            // Show all teachers if input is empty, otherwise show filtered based on current input
            const itemsToShow = query === '' ? teachers : teachers.filter(t => t.text.toLowerCase().includes(query));
            renderDropdown(itemsToShow);
            if (teachers.length > 0) { // Only show if there are teachers
                 dropdown.classList.remove('hidden');
            }
        });

        // Event listener to hide the dropdown when clicking outside
        document.addEventListener('click', function(e) {
            // Hide if the click is outside the search wrapper
            if (!searchWrapper.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Event listener for the clear button
        clearButton.addEventListener('click', function() {
            searchInput.value = '';          // Clear search input
            teacherSelect.value = '';        // Clear hidden select
            dropdown.classList.add('hidden'); // Hide dropdown
            clearButton.style.display = 'none'; // Hide clear button
            searchInput.focus();             // Refocus the input to potentially show all options again
        });

         // Initial population of the dropdown if focused immediately (e.g., tabbing)
         // This might be redundant with the focus listener but ensures initial state
         if (document.activeElement === searchInput) {
             renderDropdown(teachers);
             if (teachers.length > 0) {
                 dropdown.classList.remove('hidden');
             }
         }
    });
</script>


<script>
    <?php if (session('openModal') == 1): ?>
        toggleModal('setupScheduleModal');
    <?php endif ?>

    function onDropRoom(event, elem) {
        // Prevent default drop behavior which might be navigation
        event.preventDefault();

        // Remove visual dragover cues
        elem.classList.remove('bg-blue-100', 'border-blue-400', 'scale-105', 'shadow-lg');

        // Get data from the dragged element (Room)
        const roomId = event.dataTransfer.getData('text/plain');
        const roomElement = document.querySelector(`[data-room-id="${roomId}"]`);
        if (!roomElement) {
            console.error('Could not find dragged room element for ID:', roomId);
            return; // Exit if the dragged element can't be found
        }
        const roomName = roomElement.getAttribute('data-room-name');

        // Get data from the drop target element (Subject)
        const subjectId = elem.getAttribute('data-subject-id'); // Use data attribute directly
        const subjectName = elem.getAttribute('data-subject-name');

        if (!roomId || !roomName || !subjectId || !subjectName) {
             console.error('Missing data for room or subject.', { roomId, roomName, subjectId, subjectName });
             alert('Error: Could not retrieve room or subject details. Please try again.');
             return;
        }


        // Populate the modal fields
        const roomNameInput = document.getElementById('room_name');
        const subjectNameInput = document.getElementById('subject_name');
        const roomIdInput = document.getElementById('room_id');
        const subjectIdInput = document.getElementById('subject_id');

        if (roomNameInput && subjectNameInput && roomIdInput && subjectIdInput) {
            roomNameInput.value = roomName;
            subjectNameInput.value = subjectName;
            roomIdInput.value = roomId;
            subjectIdInput.value = subjectId;

            // Open the modal
            toggleModal('setupScheduleModal');
        } else {
            console.error('Could not find one or more modal input fields.');
            alert('Error: Could not prepare the schedule setup form. Please check the console.');
        }
    }

    // Add dragover handler to subject elements to provide visual feedback
    document.querySelectorAll('[data-subject-id]').forEach(subjectDiv => {
        subjectDiv.addEventListener('dragover', function(event) {
            event.preventDefault(); // Necessary to allow dropping
            // Add classes for visual feedback (already handled by inline ondragover, but good practice)
            // this.classList.add('bg-blue-100', 'border-blue-400', 'scale-105', 'shadow-lg');
        });
        subjectDiv.addEventListener('dragleave', function(event) {
            // Remove classes when dragging leaves (already handled by inline ondragleave)
            // this.classList.remove('bg-blue-100', 'border-blue-400', 'scale-105', 'shadow-lg');
        });
        // The ondrop is handled by the inline attribute calling onDropRoom()
    });

</script>
@endsection