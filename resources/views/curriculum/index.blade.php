@extends('layouts.admin')

@section('content')
<!-- Setup Schedule Modal -->
<div id="setupScheduleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
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

<div class="bg-gradient-to-b from-blue-500 to-blue-400 w-full">
    <div class="w-full inline-block bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
    </div>

    <div class="px-8 py-4">
        <h1 class="text-2xl font-bold text-white stroke-black stroke-1">ACADEMIC PROGRAMS</h1>

        @php($rooms = App\Models\Room::all())
        <div class="mt-4 flex items-center space-x-4">
            <a href="{{ route('room.create') }}" class="bg-blue-300 font-bold py-2 px-4 text-center rounded shadow-lg flex items-center w-fit">
                + Room <div class="mx-2"></div>
                <span class="material-symbols-outlined me-3">
                    door_front
                </span>
            </a>

            <p class="text-white text-xs self-end">Total Rooms: {{ count($rooms) }}</p>
        </div>

        <div class="mt-4 overflow-x-auto">
            <hr>
            <div class="flex space-x-4 my-1.5">
                @if (count($rooms) === 0)
                <p class="text-white text-xl font-thin my-4">No Rooms (Add rooms)</p>
                @endif
                @foreach($rooms as $room)
                <div data-room-name="{{ $room->name }}" data-room-id="{{ $room->id }}" class="bg-blue-300 border border-white rounded shadow px-4 py-3 w-64 cursor-move draggable" draggable="true" ondragstart="event.dataTransfer.setData('text/plain', '{{ $room->id }}')">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold">{{ $room->name }}</h2>
                        <p class="text-sm text-gray-500">#{{ $room->id }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-600">{{ $room->building }}</p>
                        <form action="{{ route('room.delete', ['room' => $room->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this room?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">
                                <span class="material-symbols-outlined w-4">
                                    delete
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <hr>
        </div>

        <p class="text-center text-white mb-6 mt-8">(Drag a <i>Room</i> to a <i>Subject</i> inorder to setup a schedule)</p>

        @php($subjects = App\Models\Subject::all())
        <div class="flex items-center space-x-4">
            <a href="{{ route('subject.create') }}" class="bg-blue-300 font-bold py-2 px-4 text-center rounded shadow-lg flex items-center w-fit">
                + Subject <div class="mx-2"></div>
                <span class="material-symbols-outlined me-3">
                    book
                </span>
            </a>

            <p class="text-white text-xs self-end">Total Subjects: {{ count($subjects) }}</p>
        </div>

        <div class="mt-4 overflow-x-auto">
            <hr>
            <div class="flex space-x-4 my-1.5">
                @if (count($subjects) === 0)
                <p class="text-white text-xl font-thin my-4">No Subjects (Add subjects)</p>
                @endif
                @foreach($subjects as $subject)
                <div data-subject-name="{{ $subject->name }}" class="bg-blue-300 border border-white rounded shadow px-4 py-3 w-64 cursor-move draggable" ondragover="event.preventDefault(); this.classList.add('bg-blue-400');" ondragleave="this.classList.remove('bg-blue-400');" ondrop="onDropRoom(event, this)">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold">{{ $subject->name }}</h2>
                        <p class="text-sm text-gray-500">#{{ $subject->id }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-600">{{ $subject->code }}</p>
                        <form action="{{ route('subject.delete', ['subject' => $subject->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subject?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">
                                <span class="material-symbols-outlined w-4">
                                    delete
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <hr>
        </div>


        <div class="mt-4 overflow-x-auto">
            <p class="text-white font-semibold">Existing Schedules</p>
            <!-- 'days_recurring', // M,W,F
        'start_time',
        'end_time',
        'user_id', // creator
        'room_id',
        'subject_id', -->

            @php($schedules = App\Models\RoomSchedule::all())
            <div class="mt-4 flex flex-wrap space-x-4">
                @foreach($schedules as $schedule)
                <div class="bg-blue-300 border border-white rounded shadow px-4 py-3 w-64">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold">{{ $schedule->room->name }}</h2>
                        <p class="text-sm text-gray-500">#{{ $schedule->room->id }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-600">{{ $schedule->subject->name }}</p>
                        <p class="text-gray-600 text-sm">{{ $schedule->subject->code }}</p>
                    </div>
                    <div class="flex flex-col justify-between my-1">
                        <p class="text-gray-900 text-sm">({{ implode(', ', json_decode($schedule->days_recurring)) }})</p>
                        <p class="text-gray-900 text-xs">{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-gray-600">By: {{ $schedule->teacher->getFullname() }}</p>
                        <form action="{{ route('room-schedule.delete', ['roomSchedule' => $schedule->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">
                                <span class="material-symbols-outlined w-4">
                                    delete
                                </span>
                            </button>
                        </form>
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