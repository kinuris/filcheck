@extends('layouts.admin')

@section('content')
<div class="w-full">
    <div class="w-full inline-block h-full bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
        <div class="p-4 mb-16 bg-blue-400 h-[calc(100%-8rem)]">
            <div class="flex w-full mb-3 justify-between">
                <h1 class="text-2xl font-extrabold text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]">TEACHERS</h1>
                <a class="transition-transform hover:scale-110 shadow-lg text-md rounded border border-black p-2 bg-blue-200" href="/teacher/create">CREATE NEW TEACHER</a>
            </div>

            <form action="/teacher">
                <div class="flex w-full mb-3 justify-between">
                    <select class="p-2 rounded shadow-lg bg-blue-200 border-black border" name="dept" id="dept">
                        <option value="-1">SELECT DEPARTMENT</option>
                        @php($departments = App\Models\Department::all())
                        @foreach ($departments as $department)
                        <option {{ request()->query('dept') == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->code }}</option>
                        @endforeach
                    </select>
                    <input value="{{ request()->query('search') ?? '' }}" class="rounded shadow-lg bg-blue-200 border-black border min-w-80 p-2" placeholder="Search" type="text" name="search" id="search">
                </div>
            </form>

            <table class="w-full shadow-lg">
                <thead class="bg-blue-500 text-blue-950">
                    <th class="rounded-tl-lg p-2">#</th>
                    <th>LAST NAME</th>
                    <th>FIRST NAME</th>
                    <th>M.I.</th>
                    <th>PHONE #</th>
                    <th>DEPARTMENT</th>
                    <th class="rounded-tr-lg"></th>
                </thead>
                <tbody class="bg-blue-300 border-t text-center">
                    @foreach($teachers as $teacher)
                    <tr class="@if($loop->iteration !== count($teachers)) border-b @endif">
                        @if ($loop->iteration === count($teachers))
                        <td class="rounded-bl-lg border-r p-2">{{ $teacher->id }}</td>
                        @else
                        <td class="p-2 border-r">{{ $teacher->id }}</td>
                        @endif
                        <td class="border-r">{{ $teacher->last_name }}</td>
                        <td class="border-r">{{ $teacher->first_name }}</td>
                        @if ($teacher->middle_name)
                        <td class="border-r">{{ $teacher->middle_name[0] }}.</td>
                        @else
                        <td class="border-r"></td>
                        @endif

                        <td class="border-r">{{ $teacher->phone_number }}</td>
                        <td class="border-r">{{ $teacher->getDepartment()->code }}</td>
                        <td class="flex justify-center">
                            <div class="flex">
                                <a class="flex flex-col justify-center my-1 transition-transform hover:scale-110 text-md rounded border border-black px-2 py-1 bg-blue-200" href="/teacher/edit/{{ $teacher->id }}">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </a>
                                <div class="ms-1"></div>
                                <a class="flex flex-col justify-center my-1 transition-transform hover:scale-110 text-md rounded border border-black px-2 py-1 bg-blue-200" href="/teacher/delete/{{ $teacher->id }}">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
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
@endsection