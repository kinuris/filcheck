@extends(Auth::user()->role === 'Teacher' ? 'layouts.teacher' : 'layouts.admin')

@section('title', 'Manage Students')

@section('content')
    <div class="w-[calc(100vw-300px)] min-h-screen bg-gray-50">
        <div class="w-full inline-block h-full bg-white shadow-lg">
            <div class="h-16 p-3 border-b flex items-center justify-between">
                <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo" class="h-8">
            </div>
            <div
                class="flex flex-col p-6 mb-16 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 h-[calc(100%-8rem)]">
                <div class="flex w-full mb-6 justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Student Masterlist</h1>
                        <p class="text-blue-100">Manage and monitor student information</p>
                    </div>
                    <form action="/student">
                        <div class="relative">
                            <input value="{{ request()->query('search') ?? '' }}"
                                class="bg-white/95 rounded-xl border-0 shadow-lg p-3 min-w-[400px] focus:ring-2 focus:ring-blue-300 focus:outline-none transition-all"
                                placeholder="Search by RFID, Student No. or Name" type="text" name="search"
                                id="search">
                            <button type="submit"
                                class="absolute right-3 top-2 text-gray-400 hover:text-blue-500 transition-colors">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex gap-4">
                        @if (Auth::user()->role === 'Admin')
                            <a href="/student/create"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-blue-600 bg-white rounded-xl shadow-md hover:bg-blue-50 transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                                Create New Student
                            </a>
                        @endif
                    </div>
                    <div class="flex items-center">
                        <label for="show_disabled" class="flex items-center gap-3 text-white/90 text-sm">
                            <input type="checkbox" id="show_disabled" name="show_disabled"
                                class="w-4 h-4 rounded border-white/20 focus:ring-blue-400 focus:ring-offset-2"
                                onchange="window.location.href = '{{ request()->fullUrlWithQuery(['show_disabled' => request()->query('show_disabled') ? null : '1']) }}'"
                                {{ request()->query('show_disabled') ? 'checked' : '' }}>
                            <span>Show Deactivated Students</span>
                        </label>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-600">
                            <th class="px-4 py-2 text-left font-semibold">#</th>
                            <th class="px-4 py-2 text-left font-semibold">Student No.</th>
                            <th class="px-4 py-2 text-left font-semibold">Name</th>
                            <th class="px-4 py-2 text-left font-semibold">Phone #</th>
                            <th class="px-4 py-2 text-left font-semibold">Address</th>
                            <th class="px-4 py-2 text-left font-semibold">RFID</th>
                            @if (Auth::user()->role === 'Admin')
                                <th class="px-4 py-2 text-left font-semibold">Actions</th>
                            @endif
                        </thead>
                    @php
                        $groupedStudents = $students->groupBy('section');
                    @endphp
                    <tbody class="divide-y divide-gray-100">
                        @if ($groupedStudents->isEmpty())
                            <tr>
                                <td colspan="10" class="p-3 text-center text-gray-500">No students found</td>
                            </tr>
                        @endif
                        @foreach ($groupedStudents as $section => $sectionStudents)
                            <tr class="bg-gray-100">
                                <td colspan="10" class="px-4 py-2 font-semibold">Section: {{ $section ?: 'Unassigned' }}</td>
                            </tr>
                            @foreach ($sectionStudents as $student)
                                <tr class="hover:bg-blue-50/50 transition-colors {{ $student->disabled() ? 'bg-gray-100/70' : '' }}">
                                    <td class="px-4 py-1.5 text-gray-500">{{ $student->id }}</td>
                                    <td class="px-4 py-1.5 {{ $student->disabled() ? 'text-gray-400' : '' }}">{{ $student->student_number }}</td>
                                    <td class="px-4 py-1.5 {{ $student->disabled() ? 'text-gray-400' : '' }}">{{ $student->fullName }}</td>
                                    <td class="px-4 py-1.5 text-gray-600">
                                        <a href="tel:{{ $student->phone_number }}" class="flex items-center gap-2 hover:text-blue-600 transition-colors {{ $student->disabled() ? 'text-gray-400 pointer-events-none' : '' }}">
                                            <span class="material-symbols-outlined text-xs">phone</span>
                                            {{ $student->phone_number }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-1.5 text-gray-600 truncate max-w-[180px] {{ $student->disabled() ? 'text-gray-400' : '' }}">{{ $student->address }}</td>
                                    <td class="px-4 py-1.5 {{ $student->disabled() ? 'text-gray-400' : '' }}">
                                        @if ($student->disabled())
                                            <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full">Deactivated</span>
                                        @else
                                            {{ $student->rfid }}
                                        @endif
                                    </td>
                                    @if (Auth::user()->role === 'Admin')
                                        <td class="px-4 py-1.5">
                                            <div class="flex gap-1">
                                                @if (!$student->disabled())
                                                    <a href="/student/edit/{{ $student->id }}" class="p-1 rounded-md hover:bg-blue-100 text-blue-600 transition-colors" title="Edit">
                                                        <span class="material-symbols-outlined text-sm">edit</span>
                                                    </a>
                                                    <a href="{{ route('student.decomission', $student->id) }}" onclick="return confirm('Are you sure you want to decommission this student?')" class="p-1 rounded-md hover:bg-yellow-100 text-yellow-600 transition-colors" title="Decommission">
                                                        <span class="material-symbols-outlined text-sm">person_off</span>
                                                    </a>
                                                @endif
                                                <a href="/student/delete/{{ $student->id }}" onclick="return confirm('Are you sure you want to delete this student?')" class="p-1 rounded-md hover:bg-red-100 text-red-600 transition-colors" title="Delete">
                                                    <span class="material-symbols-outlined text-sm">delete</span>
                                                </a>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    </table>
                </div>
                <div class="flex-1"></div>
                <div class="mt-6">
                    {{ $students->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
