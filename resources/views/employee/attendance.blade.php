@extends('layouts.admin')

@section('content')
<div class="w-full">
    <div class="w-full inline-block h-full bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>

        <div class="p-4 mb-16 bg-blue-400 h-[calc(100%-8rem)]">
            <div class="flex flex-col">
                <div class="flex w-full mb-3 justify-between">
                    <h1 class="text-2xl font-extrabold text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]">ATTENDANCE LOG</h1>
                    <form action="/attendance">
                        <input value="{{ request()->query('search') ?? '' }}" class="bg-blue-200 rounded border-black border shadow-lg p-2 min-w-80" placeholder="RFID | EMPLOYEE ID | NAME" type="text" name="search" id="search">
                    </form>
                </div>

                <div class="flex gap-2 my-3">
                    <a class="px-6 py-1 bg-blue-200 text-lg font-semibold border-2 border-black rounded-lg" href="?filter=">ALL</a>
                    <a class="px-6 py-1 bg-green-500 text-lg font-semibold border-2 border-black rounded-lg" href="?filter=IN">PRESENT</a>
                    <a class="px-6 py-1 bg-red-500 text-lg font-semibold border-2 border-black rounded-lg" href="?filter=OUT">ABSENT</a>
                </div>
            </div>

            <table class="w-full shadow-lg mt-4">
                <thead class="bg-blue-300 text-blue-950">
                    <th class="rounded-tl-lg p-2">#</th>
                    <th>EMPLOYEE ID</th>
                    <th>FULL NAME</th>
                    <th>DATE</th>
                    <th>TIME</th>
                    <th>TYPE</th>
                    <th class="rounded-tr-lg">LOGS</th>
                </thead>
                <tbody class="bg-blue-300 border-t text-center">
                    @foreach ($users as $index => $user)
                    @php($latestLog = $user->gateLogs()->latest()->first())
                    <tr>
                        <td class="p-2">{{ $index + 1 }}</td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->getFullname() }}</td>
                        @if ($latestLog)
                        <td>{{ $latestLog->day }}</td>
                        <td>{{ \Carbon\Carbon::parse($latestLog->time)->format('h:i A') }}</td>
                        <td>
                            @if ($latestLog->type == 'IN')
                            <span class="text-green-600">{{ $latestLog->type }}</span>
                            @else
                            <span class="text-red-600">{{ $latestLog->type }}</span>
                            @endif
                        </td>
                        @else
                        <td>(NONE)</td>
                        <td>(NONE)</td>
                        <td>(NONE)</td>
                        @endif
                        <td class="rounded-br-lg">
                            <button data-info-id="{{ $user->id }}" data-modal-btn="openViewLogsModal" class="p-1 px-2 rounded bg-blue-500 text-white font-bold">VIEW LOGS</button>
                            <a href="/attendance/record/csv/{{ $user->id }}" class="p-1 px-2 rounded bg-gray-500 text-white">CSV</a>
                            <a href="/attendance/record/pdf/{{ $user->id }}" class="p-1 px-2 rounded bg-gray-500 text-white">PDF</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection