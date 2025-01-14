
@extends(Auth::user()->role === 'Teacher' ? 'layouts.teacher' : 'layouts.admin')

@section('content')
<div class="w-full">
    <div class="w-full inline-block h-full bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
        <div class="flex flex-col p-4 mb-16 bg-blue-400 h-[calc(100%-8rem)]">
            <div class="flex w-full mb-3 justify-between">
                <h1 class="text-2xl font-extrabold text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]">STUDENT MASTERLIST</h1>
                <form action="/student">
                    <input value="{{ request()->query('search') ?? '' }}" class="bg-blue-200 rounded border-black border shadow-lg p-2 min-w-80" placeholder="RFID | STUDENT NO. | STUDENT NAME" type="text" name="search" id="search">
                </form>
            </div>

            @if (Auth::user()->role === 'Admin')
            <a class="max-w-fit mb-5 mt-2 transition-transform hover:scale-110 shadow-lg text-md rounded border border-black p-2 bg-blue-200" href="/student/create">CREATE NEW STUDENT</a>
            @endif

            <table class="w-full shadow-lg mt-4">
                <thead class="bg-blue-500 text-blue-950">
                    <th class="rounded-tl-lg p-2">#</th>
                    <th>STUDENT NO.</th>
                    <th>LAST NAME</th>
                    <th>FIRST NAME</th>
                    <th>M.I.</th>
                    <th>PARENT or<br>GUARDIAN</th>
                    <th>PHONE #</th>
                    <th>ADDRESS</th>
                    @if (Auth::user()->role === 'Admin')
                    <th>RFID</th>
                    @else
                    <th class="rounded-tr-lg">RFID</th>
                    @endif

                    @if (Auth::user()->role === 'Admin')
                    <td class="rounded-tr-lg w-6"></td>
                    @endif
                </thead>
                <tbody class="bg-blue-300 border-t text-center">
                    @if(empty($students->items()))
                    <tr>
                        <td class="rounded-bl-lg p-2"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if (Auth::user()->role === 'Admin')
                        <td></td>
                        @endif
                        <td class="rounded-br-lg p-2"></td>
                    </tr>
                    @endif
                    @foreach($students as $student)
                    <tr class="@if($loop->iteration !== count($students)) border-b @endif">
                        @if ($loop->iteration === count($students))
                        <td class="rounded-bl-lg border-r p-2">{{ $student->id }}</td>
                        @else
                        <td class="p-2 border-r">{{ $student->id }}</td>
                        @endif
                        <td class="border-r">{{ $student->student_number }}</td>
                        <td class="border-r">{{ $student->last_name }}</td>
                        <td class="border-r">{{ $student->first_name }}</td>
                        @if ($student->middle_name)
                        <td class="border-r">{{ $student->middle_name[0] }}.</td>
                        @else
                        <td class="border-r"></td>
                        @endif

                        <td class="border-r">{{ $student->guardian }}</td>
                        <td class="border-r">{{ $student->phone_number }}</td>
                        <td class="border-r">{{ $student->address }}</td>
                        @if (Auth::user()->role === 'Teacher')
                        <td class="rounded-br-lg">{{ $student->rfid }}</td>
                        @else
                        <td class="border-r">{{ $student->rfid }}</td>
                        @endif
                        @if (Auth::user()->role === 'Admin')
                        <td class="flex justify-center px-2">
                            <div class="flex">
                                <a class="flex flex-col justify-center my-1 transition-transform hover:scale-110 text-md rounded border border-black px-2 py-1 bg-blue-200" href="/student/edit/{{ $student->id }}">
                                    <span class="material-symbols-outlined">
                                        edit
                                    </span>
                                </a>
                                <div class="ms-1"></div>
                                <a class="flex flex-col justify-center my-1 transition-transform hover:scale-110 text-md rounded border border-black px-2 py-1 bg-blue-200" href="/student/delete/{{ $student->id }}">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex-1"></div>
            <div>
                {{ $students->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection