@extends('layouts.admin')

@section('content')
<div class="w-full min-h-screen bg-gray-50">
    <div class="w-full inline-block h-full bg-white shadow-lg">
        <div class="h-16 p-4 border-b">
            <img class="h-full" src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
        <div class="p-6 mb-16 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 h-[calc(100%-8rem)]">
            <div class="flex w-full mb-6 justify-between items-center">
                <h1 class="text-3xl font-bold text-white">Teachers Directory</h1>
                <a class="transition-all duration-300 hover:scale-105 shadow-lg text-md rounded-lg px-4 py-2 bg-white text-blue-700 hover:bg-blue-50 font-semibold flex items-center gap-2" href="/teacher/create">
                    <span class="material-symbols-outlined">add</span>
                    Add New Teacher
                </a>
            </div>

            <form action="/teacher" class="mb-6">
                <div class="flex w-full gap-4 items-center">
                    <select class="p-2 rounded-lg shadow-lg bg-white text-gray-700 border-0 focus:ring-2 focus:ring-blue-500 transition-all duration-300 w-64" name="dept" id="dept">
                        <option value="-1">Filter by Department</option>
                        @php($departments = App\Models\Department::all())
                        @foreach ($departments as $department)
                        <option {{ request()->query('dept') == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->code }}</option>
                        @endforeach
                    </select>
                    <div class="relative flex-1">
                        <input value="{{ request()->query('search') ?? '' }}" class="w-full rounded-lg shadow-lg bg-white border-0 p-2 pl-10 focus:ring-2 focus:ring-blue-500 transition-all duration-300" placeholder="Search teachers..." type="text" name="search" id="search">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-400">search</span>
                    </div>
                </div>
            </form>

            <div class="bg-white rounded-xl shadow-xl overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="p-2.5 text-left font-semibold">#</th>
                            <th class="p-2.5 text-left font-semibold">Last Name</th>
                            <th class="p-2.5 text-left font-semibold">First Name</th>
                            <th class="p-2.5 text-left font-semibold">M.I.</th>
                            <th class="p-2.5 text-left font-semibold">Phone #</th>
                            <th class="p-2.5 text-left font-semibold">Department</th>
                            <th class="p-2.5 text-right font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                        <tr class="border-t hover:bg-gray-50 transition-colors">
                            <td class="p-2.5">{{ $teacher->id }}</td>
                            <td class="p-2.5">{{ $teacher->last_name }}</td>
                            <td class="p-2.5">{{ $teacher->first_name }}</td>
                            <td class="p-2.5">{{ $teacher->middle_name ? $teacher->middle_name[0] . '.' : '' }}</td>
                            <td class="p-2.5">{{ $teacher->phone_number }}</td>
                            <td class="p-2.5">{{ $teacher->department->code }}</td>
                            <td class="p-2.5">
                                <div class="flex gap-2 justify-end">
                                    <a class="transition-all duration-300 hover:scale-105 p-2 rounded-lg text-blue-600 hover:bg-blue-50" href="/teacher/edit/{{ $teacher->id }}" title="Edit">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <a class="transition-all duration-300 hover:scale-105 p-2 rounded-lg text-red-600 hover:bg-red-50" href="/teacher/delete/{{ $teacher->id }}" title="Delete">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection