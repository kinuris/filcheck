@extends(Auth::user()->role === 'Teacher' ? 'layouts.teacher' : 'layouts.admin')

@section('content')
<div class="w-[calc(100vw-300px)] min-h-screen bg-gray-50">
    <div class="w-full inline-block h-full bg-white shadow-lg">
        <div class="h-16 p-3 border-b flex items-center justify-between">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo" class="h-8">
        </div>
        <div class="flex flex-col p-6 mb-16 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 h-[calc(100%-8rem)]">
            <div class="flex w-full mb-6 justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Student Masterlist</h1>
                    <p class="text-blue-100">Manage and monitor student information</p>
                </div>
                <form action="/student">
                    <div class="relative">
                        <input value="{{ request()->query('search') ?? '' }}"
                            class="bg-white/95 rounded-xl border-0 shadow-lg p-3 min-w-[400px] focus:ring-2 focus:ring-blue-300 focus:outline-none transition-all"
                            placeholder="Search by RFID, Student No. or Name"
                            type="text"
                            name="search"
                            id="search">
                        <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-blue-500 transition-colors">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                    </div>
                </form>
            </div>

            @if (Auth::user()->role === 'Admin')
            <a class="max-w-fit mb-6 transition-all hover:scale-102 shadow-lg text-md rounded-xl px-5 py-2.5 bg-white text-blue-600 font-semibold hover:bg-blue-50 flex items-center gap-2" href="/student/create">
                <span class="material-symbols-outlined">add_circle</span>
                Create New Student
            </a>
            @endif

            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 text-gray-700">
                        <th class="px-3 py-2.5 text-left font-semibold">#</th>
                        <th class="px-3 py-2.5 text-left font-semibold">Student No.</th>
                        <th class="px-3 py-2.5 text-left font-semibold">Last Name</th>
                        <th class="px-3 py-2.5 text-left font-semibold">First Name</th>
                        <th class="px-3 py-2.5 text-left font-semibold">M.I.</th>
                        <th class="px-3 py-2.5 text-left font-semibold">Phone #</th>
                        <th class="px-3 py-2.5 text-left font-semibold">Address</th>
                        <th class="px-3 py-2.5 text-left font-semibold">RFID</th>
                        @if (Auth::user()->role === 'Admin')
                        <th class="px-3 py-2.5 text-left font-semibold">Actions</th>
                        @endif
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if(empty($students->items()))
                        <tr>
                            <td colspan="10" class="p-3 text-center text-gray-500">No students found</td>
                        </tr>
                        @endif
                        @foreach($students as $student)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-3 py-2.5">{{ $student->id }}</td>
                            <td class="px-3 py-2.5 font-medium">{{ $student->student_number }}</td>
                            <td class="px-3 py-2.5">{{ $student->last_name }}</td>
                            <td class="px-3 py-2.5">{{ $student->first_name }}</td>
                            <td class="px-3 py-2.5">{{ $student->middle_name ? $student->middle_name[0] . '.' : '' }}</td>
                            <td class="px-3 py-2.5">{{ $student->phone_number }}</td>
                            <td class="px-3 py-2.5 truncate max-w-[200px]">{{ $student->address }}</td>
                            <td class="px-3 py-2.5 font-medium">{{ $student->rfid }}</td>
                            @if (Auth::user()->role === 'Admin')
                            <td class="px-3 py-2.5">
                                <div class="flex gap-2">
                                    <a href="/student/edit/{{ $student->id }}" class="p-1.5 rounded-lg hover:bg-blue-100 text-blue-600 transition-colors" title="Edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a href="/student/delete/{{ $student->id }}" 
                                       onclick="return confirm('Are you sure you want to delete this student?')" 
                                       class="p-1.5 rounded-lg hover:bg-red-100 text-red-600 transition-colors"
                                       title="Delete">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                </div>
                            </td>
                            @endif
                        </tr>
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