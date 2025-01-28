@extends('layouts.admin')

@section('content')
<!-- Setup Schedule Modal -->
<div id="setupScheduleModal" class="hidden z-50 fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3 min-w-[500px]">
        <div class="flex justify-between items-center ">
            <h2 class="text-xl font-bold">Setup Schedule</h2>

            <button onclick="toggleModal('setupScheduleModal')" class="text-gray-500">&times;</button>
        </div>

        @if ($errors->has('conflict'))
        <div class="text-red-500 text-sm mb-4">
            {{ $errors->first('conflict') }}
        </div>
        @endif

        <form action="{{ route('room-schedule.create') }}" method="POST">
            <div class="mb-4 flex space-x-4">
                <div class="w-1/2">
                    <label for="room_id" class="block text-gray-700 font-semibold text-sm">Room</label>
                    <input type="text" id="room_name" name="room_name" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" value="{{ old('room_name') }}" readonly>
                    <input type="hidden" name="room_id" id="room_id" value="{{ old('room_id') }}">
                </div>
                <div class="w-1/2">
                    <label for="subject_id" class="block text-gray-700 font-semibold text-sm">Subject</label>
                    <input type="text" id="subject_name" name="subject_name" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" value="{{ old('subject_name') }}" readonly>
                    <input type="hidden" name="subject_id" id="subject_id" value="{{ old('subject_id') }}">
                </div>
            </div>

            @csrf
            <div class="mt-10">
                <label class="block text-gray-700 font-semibold text-sm">Days</label>
                <div class="flex justify-between flex-wrap">
                    @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="mr-4 flex items-center space-x-2">
                        <label>
                            <span>{{ $day }}</span>
                        </label>
                        <input type="checkbox" name="days[]" value="{{ $day }}" class="form-checkbox h-4 w-4 text-blue-600" {{ in_array($day, old('days', [])) ? 'checked' : '' }}>
                    </div>
                    @endforeach
                </div>
                @error('days')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-10 flex space-x-4">
                <div class="w-1/2">
                    <label for="start_time" class="block text-gray-700 font-semibold text-sm">Start Time</label>
                    <input type="time" name="start_time" id="start_time" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('start_time') }}">
                    @error('start_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2">
                    <label for="end_time" class="block text-gray-700 font-semibold text-sm">End Time</label>
                    <input type="time" name="end_time" id="end_time" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('end_time') }}">
                    @error('end_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-10">
                <label for="teacher_id" class="block text-gray-700 font-semibold text-sm">Teacher</label>
                <select name="teacher_id" id="teacher_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="" disabled selected>Select a teacher</option>
                    @foreach(App\Models\User::where('role', 'teacher')->get() as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->getFullname() }}
                    </option>
                    @endforeach
                </select>
                @error('teacher_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-10">
                <label for="section_id" class="block text-gray-700 font-semibold text-sm">Section</label>
                <select name="section" id="section_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="" disabled selected>Select a section</option>
                    @foreach(App\Models\StudentInfo::distinct('section')->pluck('section') as $section)
                    <option value="{{ $section }}">
                        {{ $section }}
                    </option>
                    @endforeach
                </select>
                @error('section_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end mt-10">
                <button type="button" onclick="toggleModal('setupScheduleModal')" class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>

<div class="min-h-screen max-h-[calc(100vh-4em)] bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 min-w-[calc(100vw-300px)] overflow-auto">
    <!-- Header -->
    <div class="w-full bg-white shadow-lg">
        <div class="container mx-auto h-20 p-4 flex items-center">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="FilCheck Logo" class="h-12">
        </div>
    </div>

    <div class="container mx-auto px-8 py-6">
        <!-- Title Section -->
        <h1 class="text-4xl font-bold text-white mb-10 tracking-tight">Academic Programs Management</h1>

        <!-- Rooms Management Section -->
        @php($rooms = App\Models\Room::all())
        <div class="bg-white/40 backdrop-blur-md rounded-xl p-8 mb-6 shadow-xl">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <h2 class="text-2xl font-bold text-white">Room Management</h2>
                    <span class="bg-white/20 px-4 py-1 rounded-full text-white text-sm">
                        {{ count($rooms) }} Available
                    </span>
                </div>
                <a href="{{ route('room.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition-all duration-300 flex items-center group">
                    <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">add_circle</span>
                    New Room
                </a>
            </div>

            <div class="overflow-x-auto">
                <div class="flex space-x-6 py-4">
                    @if (count($rooms) === 0)
                    <div class="w-full text-center py-8">
                        <span class="material-symbols-outlined text-white/50 text-4xl mb-2">inventory_2</span>
                        <p class="text-white text-xl font-light">No Rooms Available</p>
                    </div>
                    @endif
                    @foreach($rooms as $room)
                    <div data-room-name="{{ $room->name }}"
                        data-room-id="{{ $room->id }}"
                        class="bg-white rounded-xl shadow-lg px-6 py-4 w-80 min-w-[33.333%] cursor-move draggable 
                    hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300"
                        draggable="true"
                        ondragstart="event.dataTransfer.setData('text/plain', '{{ $room->id }}')">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $room->name }}</h3>
                                <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">ID: {{ $room->id }}</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <a href="" class="p-2 hover:bg-gray-100 rounded-full transition-colors duration-300">
                                    <span class="material-symbols-outlined text-blue-500">edit</span>
                                </a>
                                <form action="{{ route('room.delete', ['room' => $room->id]) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this room? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-gray-100 rounded-full transition-colors duration-300">
                                        <span class="material-symbols-outlined text-red-500">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-700 bg-gray-50 p-2 rounded-lg">
                            <span class="material-symbols-outlined text-gray-500">location_on</span>
                            <p class="font-medium">{{ $room->building }}</p>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-gray-500 border-t pt-3">
                            <span class="material-symbols-outlined mr-2 text-gray-400">drag_indicator</span>
                            <p>Drag to assign to a subject</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4 mb-6 flex items-center justify-center space-x-3">
            <span class="material-symbols-outlined text-white">info</span>
            <p class="text-white text-lg font-medium">Drag a Room to a Subject to Create a Schedule</p>
        </div>

        <!-- Subjects Section -->
        @php($subjects = App\Models\Subject::all())
        <div class="bg-white/40 backdrop-blur-md rounded-xl p-8 mb-10 shadow-xl">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <h2 class="text-2xl font-bold text-white">Subjects Management</h2>
                    <span class="bg-white/20 px-4 py-1 rounded-full text-white text-sm">
                        {{ count($subjects) }} Subjects
                    </span>
                </div>
                <a href="{{ route('subject.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition-all duration-300 flex items-center group">
                    <span class="material-symbols-outlined mr-2 group-hover:scale-110 transition-transform">add_circle</span>
                    New Subject
                </a>
            </div>

            <div class="overflow-x-auto">
                <div class="flex space-x-6 py-4">
                    @if (count($subjects) === 0)
                    <div class="w-full text-center py-8">
                        <span class="material-symbols-outlined text-white/50 text-4xl mb-2">menu_book</span>
                        <p class="text-white text-xl font-light">No Subjects Available</p>
                    </div>
                    @endif
                    @foreach($subjects as $subject)
                    <div data-subject-name="{{ $subject->name }}"
                        class="bg-white rounded-xl shadow-lg px-6 py-4 w-80 min-w-[33.333%] transition-all duration-300 hover:shadow-2xl relative group"
                        ondragover="event.preventDefault(); this.classList.add('bg-blue-100', 'scale-105', 'ring-4', 'ring-blue-500', 'shadow-xl', 'shadow-indigo-200');"
                        ondragleave="this.classList.remove('bg-blue-100', 'scale-105', 'ring-4', 'ring-blue-500', 'shadow-xl', 'shadow-indigo-200');" 
                        ondrop="onDropRoom(event, this); this.classList.remove('bg-blue-100', 'scale-105', 'ring-4', 'ring-blue-500', 'shadow-xl', 'shadow-indigo-200');">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $subject->name }}</h2>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="material-symbols-outlined text-gray-400 text-sm">tag</span>
                                    <p class="text-sm text-gray-600 font-medium">{{ $subject->code }}</p>
                                </div>
                            </div>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">ID: {{ $subject->id }}</span>
                        </div>
                        <div class="flex justify-between items-center mt-4 pt-3 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="material-symbols-outlined mr-2 text-gray-400">drag_indicator</span>
                                <p>Drop room here to schedule</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="" class="p-2 hover:bg-gray-100 rounded-full transition-colors duration-300">
                                    <span class="material-symbols-outlined text-blue-500">edit</span>
                                </a>
                                <form action="{{ route('subject.delete', ['subject' => $subject->id]) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this subject? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-gray-100 rounded-full transition-colors duration-300">
                                        <span class="material-symbols-outlined text-red-500">delete</span>
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
        <div class="bg-white/40 backdrop-blur-md rounded-xl p-8 shadow-xl">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-4">
                    <h2 class="text-2xl font-bold text-white">Current Schedule Overview</h2>
                    <span class="bg-white/20 px-4 py-1 rounded-full text-white text-sm">
                        {{ count($schedules) }} Schedules
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($schedules as $schedule)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-white">{{ $schedule->room->name }}</h3>
                            <span class="bg-white/20 text-white text-sm px-3 py-1 rounded-full">Room {{ $schedule->room->id }}</span>
                        </div>
                    </div>

                    <div class="px-6 py-4 space-y-4">
                        <div class="flex flex-col space-y-1">
                            <div class="flex justify-between items-center">
                                <p class="text-gray-800 font-bold text-lg">{{ $schedule->subject->name }}</p>
                                <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-sm font-medium">{{ $schedule->subject->code }}</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex flex-wrap gap-1">
                            <div class="flex items-center text-gray-600">
                                <span class="material-symbols-outlined mr-2">calendar_today</span>
                            </div>
                                @foreach(json_decode($schedule->days_recurring) as $day)
                                    <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">{{ $day }}</span>
                                @endforeach
                            </div>
                            <div class="flex items-center text-gray-600">
                                <span class="material-symbols-outlined mr-2">schedule</span>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-2">
                                <span class="material-symbols-outlined text-gray-500">person</span>
                                <p class="text-gray-700 font-medium">{{ $schedule->teacher->getFullname() }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href=""
                                    class="p-2 hover:bg-blue-50 rounded-full text-blue-500 transition-colors duration-300">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <form action="{{ route('room-schedule.delete', ['roomSchedule' => $schedule->id]) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 hover:bg-red-50 rounded-full text-red-500 transition-colors duration-300">
                                        <span class="material-symbols-outlined">delete</span>
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
@endsection

@section('script')
<script>
    <?php if (session('openModal') == 1): ?>
        toggleModal('setupScheduleModal');
    <?php endif ?>

    function onDropRoom(event, elem) {
        elem.classList.remove('bg-blue-400');
        const roomId = event.dataTransfer.getData('text/plain');

        const subjectId = elem.querySelector('p.text-sm').textContent.replace('#', '');
        const roomName = document.querySelector(`[data-room-name][data-room-id="${roomId}"]`).getAttribute('data-room-name');
        const subjectName = elem.getAttribute('data-subject-name');

        document.getElementById('room_name').value = roomName;
        document.getElementById('subject_name').value = subjectName;

        toggleModal('setupScheduleModal');

        document.getElementById('room_id').value = roomId;
        document.getElementById('subject_id').value = subjectId;
    }
</script>
@endsection