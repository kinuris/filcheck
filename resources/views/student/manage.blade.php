@extends(Auth::user()->role === 'Teacher' ? 'layouts.teacher' : 'layouts.admin')

@section('title', 'Manage Students')

@section('content')
    <div class="w-[calc(100vw-300px)] min-h-screen bg-gray-50">
        <div class="w-full h-full bg-white shadow-lg">
            <div class="h-16 px-6 border-b flex items-center justify-between">
                <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo" class="h-8">
            </div>
            <div class="flex flex-col p-8 mb-16 bg-gradient-to-r from-blue-700 to-blue-500 h-[calc(100%-8rem)]">
                <div class="flex w-full mb-8 justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Student Management</h1>
                        <p class="text-blue-100">Comprehensive student information system</p>
                    </div>
                    <form action="/student">
                        <div class="relative">
                            <input value="{{ request()->query('search') ?? '' }}"
                                class="bg-white/95 rounded-lg border-0 shadow-lg p-3 pl-10 min-w-[400px] focus:ring-2 focus:ring-blue-300 focus:outline-none transition-all"
                                placeholder="Search by RFID, Student No. or Name" type="text" name="search"
                                id="search">
                            <span class="material-symbols-outlined absolute left-3 top-3 text-gray-400">search</span>
                            <button type="submit"
                                class="absolute right-3 top-2.5 h-8 bg-blue-600 text-white p-1 rounded-md hover:bg-blue-700 transition-colors">
                                <span class="material-symbols-outlined text-sm">search</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex gap-4">
                        @if (Auth::user()->role === 'Admin')
                            <a href="/student/create"
                                class="flex items-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 transition-all duration-200">
                                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                                Create New Student
                            </a>
                        @endif
                    </div>
                    <div class="flex items-center">
                        <label for="show_disabled" class="flex items-center gap-3 text-white/90 text-sm font-medium">
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
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold tracking-wider">#</th>
                                <th class="px-6 py-3 text-left font-semibold tracking-wider">Student No.</th>
                                <th class="px-6 py-3 text-left font-semibold tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left font-semibold tracking-wider">Phone #</th>
                                <th class="px-6 py-3 text-left font-semibold tracking-wider">Address</th>
                                <th class="px-6 py-3 text-left font-semibold tracking-wider">RFID</th>
                                @if (Auth::user()->role === 'Admin')
                                    <th class="px-6 py-3 text-left font-semibold tracking-wider">Actions</th>
                                @endif
                            </tr>
                        </thead>
                    @php
                        $groupedStudents = $students->groupBy('section');
                    @endphp
                    <tbody class="divide-y divide-gray-200">
                        @if ($groupedStudents->isEmpty())
                            <tr>
                                <td colspan="10" class="p-4 text-center text-gray-500">No students found</td>
                            </tr>
                        @endif
                        @foreach ($groupedStudents as $section => $sectionStudents)
                            <tr class="bg-gray-50">
                                <td colspan="10" class="px-6 py-3 font-medium text-blue-600">Section: {{ $section ?: 'Unassigned' }}</td>
                            </tr>
                            @foreach ($sectionStudents as $student)
                                <tr class="hover:bg-blue-50/50 transition-colors {{ $student->disabled() ? 'bg-gray-50/70' : '' }}">
                                    <td class="px-6 py-3 text-gray-500">{{ $student->id }}</td>
                                    <td class="px-6 py-3 font-medium {{ $student->disabled() ? 'text-gray-400' : 'text-gray-800' }}">{{ $student->student_number }}</td>
                                    <td class="px-6 py-3 font-medium {{ $student->disabled() ? 'text-gray-400' : 'text-gray-800' }}">{{ $student->fullName }}</td>
                                    <td class="px-6 py-3 text-gray-600">
                                        <a href="tel:{{ $student->phone_number }}" class="flex items-center gap-2 hover:text-blue-600 transition-colors {{ $student->disabled() ? 'text-gray-400 pointer-events-none' : '' }}">
                                            <span class="material-symbols-outlined text-xs">phone</span>
                                            {{ $student->phone_number }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3 text-gray-600 truncate max-w-[180px] {{ $student->disabled() ? 'text-gray-400' : '' }}">{{ $student->address }}</td>
                                    <td class="px-6 py-3 {{ $student->disabled() ? 'text-gray-400' : '' }}">
                                        @if ($student->disabled())
                                            <span class="text-xs bg-gray-200 text-gray-600 px-2.5 py-1 rounded-full">Deactivated</span>
                                        @else
                                            <span class="font-medium">{{ $student->rfid }}</span>
                                        @endif
                                    </td>
                                    @if (Auth::user()->role === 'Admin')
                                        <td class="px-6 py-3">
                                            <div class="flex gap-2">
                                                @if (!$student->disabled())
                                                    <a href="/student/edit/{{ $student->id }}" class="p-1.5 rounded-md hover:bg-blue-100 text-blue-600 transition-colors" title="Edit">
                                                        <span class="material-symbols-outlined text-sm">edit</span>
                                                    </a>
                                                    <a href="{{ route('student.decomission', $student->id) }}" onclick="return confirm('Are you sure you want to decommission this student?')" class="p-1.5 rounded-md hover:bg-yellow-100 text-yellow-600 transition-colors" title="Decommission">
                                                        <span class="material-symbols-outlined text-sm">person_off</span>
                                                    </a>
                                                @endif
                                                <a href="/student/delete/{{ $student->id }}" onclick="return confirm('Are you sure you want to delete this student?')" class="p-1.5 rounded-md hover:bg-red-100 text-red-600 transition-colors" title="Delete">
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
                <div class="mt-8">
                    {{ $students->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
