@extends('layouts.admin')

@section('content')
<div class="min-h-screen max-h-[calc(100vh-4em)] bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 min-w-[calc(100vw-300px)] overflow-auto">
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg p-4 mb-6">
            <h2 class="text-xl font-bold mb-3 flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Schedule Information
            </h2>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-gray-50 p-3 rounded-lg shadow-sm">
                    <h3 class="text-gray-700 font-semibold mb-2 flex items-center">
                        <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Schedule
                    </h3>
                    <div class="flex flex-wrap gap-1">
                        @foreach(json_decode($schedule->days_recurring) as $day)
                        <span class="px-2 py-1 bg-blue-500 text-white rounded text-xs font-medium">
                            {{ $day }}
                        </span>
                        @endforeach
                    </div>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg shadow-sm">
                    <h3 class="text-gray-700 font-semibold mb-2 flex items-center">
                        <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Time
                    </h3>
                    <p class="text-gray-600 text-sm">
                        {{ date('h:i A', strtotime($schedule->start_time)) }} -
                        {{ date('h:i A', strtotime($schedule->end_time)) }}
                    </p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg shadow-sm">
                    <h3 class="text-gray-700 font-semibold mb-2 flex items-center">
                        <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Instructor
                    </h3>
                    <p class="text-gray-600 text-sm">{{ $schedule->teacher->getFullname() }}</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg shadow-sm">
                    <h3 class="text-gray-700 font-semibold mb-2 flex items-center">
                        <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Section
                    </h3>
                    <p class="text-gray-600 text-sm">{{ $schedule->section }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Irregular Students</h2>
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 text-left">Student ID</th>
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Days</th>
                        <th class="py-2 px-4 text-left">Year Level</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($irregulars as $irregular)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $irregular->student->student_number }}</td>
                        <td class="py-2 px-4">{{ $irregular->student->fullName }}</td>
                        <td class="py-2 px-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach(json_decode($irregular->days_recurring) as $day)
                                <span class="px-2 py-1 bg-blue-500 text-white rounded text-xs font-medium">
                                    {{ $day }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-2 px-4">{{ $irregular->student->year }}</td>
                        <td class="py-2 px-4">
                            <form action="{{ route('irregular.destroy', $irregular->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to remove this student?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md transition duration-200 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @php($students = App\Models\StudentInfo::query()->whereDoesntHave('disabledRelation')->get())
                    <tr class="border-b bg-blue-50">
                        <form action="{{ route('irregular.store', $schedule->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                            <td colspan="5" class="py-4 px-6">
                                <div class="border-2 border-blue-200 rounded-lg p-4 bg-white shadow-sm">
                                    <h3 class="text-lg font-bold text-blue-700 mb-4">Add New Irregular Student</h3>
                                    <div class="relative">
                                        <label for="student_search" class="block text-sm font-medium text-gray-700 mb-2">Search Student</label>
                                        <input type="text"
                                            id="student_search"
                                            class="border-2 rounded-lg px-3 py-2 w-full focus:ring-2 focus:ring-blue-300 focus:border-blue-500 outline-none @error('student_id') border-red-500 @enderror"
                                            placeholder="Enter student name or ID..."
                                            autocomplete="off">
                                        @error('student_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                        <input type="hidden" name="student_id" id="selected_student_id">
                                        <div id="students_dropdown" class="hidden absolute z-10 w-full bg-white border-2 rounded-lg mt-1 max-h-60 overflow-y-auto shadow-lg">
                                            @foreach($students as $student)
                                            <div class="student-option p-3 hover:bg-blue-50 cursor-pointer border-b"
                                                data-student-id="{{ $student->id }}"
                                                data-name="{{ $student->fullName }}"
                                                data-year="{{ $student->year_level }}">
                                                <span class="font-medium">{{ $student->student_number }}</span> - {{ $student->fullName }}
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="mt-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <h4 class="text-sm font-bold text-gray-700 mb-3">Select Days to Attend:</h4>
                                        <div class="flex flex-wrap gap-4">
                                            @foreach(json_decode($schedule->days_recurring) as $day)
                                            <label class="flex items-center space-x-2 cursor-pointer hover:bg-blue-50 p-2 rounded">
                                                <input type="checkbox"
                                                    name="days[]"
                                                    value="{{ $day }}"
                                                    {{ in_array($day, old('days', [])) ? 'checked' : '' }}
                                                    class="form-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 @error('days') border-red-500 @enderror">
                                                <span class="text-sm font-medium text-gray-700">{{ $day }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                        @error('days')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit"
                                        class="mt-4 w-full bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 ease-in-out font-medium">
                                        Add Student to Schedule
                                    </button>
                                </div>
                            </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('student_search');
        const dropdown = document.getElementById('students_dropdown');
        const studentOptions = document.querySelectorAll('.student-option');
        const selectedStudentId = document.getElementById('selected_student_id');

        searchInput.addEventListener('input', function() {
            if (this.value.length === 0) {
                dropdown.classList.add('hidden');
                return;
            }

            const searchTerm = this.value.toLowerCase();
            dropdown.classList.remove('hidden');

            studentOptions.forEach(option => {
                const text = option.getAttribute('data-name').toLowerCase();
                option.style.display = text.includes(searchTerm) ? 'block' : 'none';
            });
        });

        studentOptions.forEach(option => {
            option.addEventListener('click', function() {
                const studentId = this.dataset.studentId;
                searchInput.value = this.textContent.trim();
                selectedStudentId.value = studentId;
                dropdown.classList.add('hidden');
            });
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>
@endsection