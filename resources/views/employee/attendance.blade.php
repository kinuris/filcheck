@extends('layouts.admin')

@section('content')
<div class="w-[calc(100vw-300px)] min-h-screen bg-gray-50">
    <div class="w-full inline-block h-full bg-white shadow-lg">
        <div class="h-16 p-4 border-b">
            <img class="h-full" src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>

        <div class="flex flex-col p-8 mb-16 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 h-[calc(100%-8rem)]">
            <div class="flex flex-col">
                <div class="flex w-full mb-6 justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">Attendance Log</h1>
                    <form action="/attendance">
                        <input value="{{ request()->query('search') ?? '' }}" 
                            class="bg-white/90 rounded-lg border-0 shadow-lg p-3 min-w-96 focus:ring-2 focus:ring-blue-300 focus:outline-none" 
                            placeholder="Search by RFID, Employee ID or Name" 
                            type="text" name="search" id="search">
                    </form>
                </div>

                <div class="flex gap-3 my-4">
                    <a class="px-6 py-2 bg-white/90 text-blue-700 text-sm font-semibold rounded-lg hover:bg-white transition-colors" href="?filter=">All Records</a>
                    <a class="px-6 py-2 bg-emerald-500 text-white text-sm font-semibold rounded-lg hover:bg-emerald-600 transition-colors" href="?filter=IN">Present</a>
                    <a class="px-6 py-2 bg-red-500 text-white text-sm font-semibold rounded-lg hover:bg-red-600 transition-colors" href="?filter=OUT">Absent</a>
                </div>
            </div>

            <div class="bg-white/90 rounded-lg shadow-xl mt-4 overflow-hidden">
                <table class="w-full bg-white">
                    <thead class="border-b">
                        <th class="p-2.5 text-left font-semibold text-gray-900">#</th>
                        <th class="p-2.5 text-left font-semibold text-gray-900">Employee ID</th>
                        <th class="p-2.5 text-left font-semibold text-gray-900">Full Name</th>
                        <th class="p-2.5 text-left font-semibold text-gray-900">Date</th>
                        <th class="p-2.5 text-left font-semibold text-gray-900">Time</th>
                        <th class="p-2.5 text-left font-semibold text-gray-900">Status</th>
                        <th class="p-2.5 text-right font-semibold text-gray-900">Actions</th>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($users as $index => $user)
                        @php($latestLog = $user->gateLogs()->latest()->first())
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-2.5">{{ $index + 1 }}</td>
                            <td class="p-2.5">{{ $user->id }}</td>
                            <td class="p-2.5 font-medium">{{ $user->getFullname() }}</td>
                            @if ($latestLog)
                            <td class="p-2.5">{{ $latestLog->day }}</td>
                            <td class="p-2.5">{{ \Carbon\Carbon::parse($latestLog->time)->format('h:i A') }}</td>
                            <td class="p-2.5">
                                @if ($latestLog->type == 'IN')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium">Present</span>
                                @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">Absent</span>
                                @endif
                            </td>
                            @else
                            <td class="p-2.5 text-gray-500">-</td>
                            <td class="p-2.5 text-gray-500">-</td>
                            <td class="p-2.5 text-gray-500">-</td>
                            @endif
                            <td class="p-2.5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button data-info-id="{{ $user->id }}" data-modal-btn="openViewLogsModal" 
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View Logs
                                    </button>
                                    <a href="/attendance/record/csv/{{ $user->id }}" 
                                        class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition-colors shadow-sm border border-gray-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        CSV
                                    </a>
                                    <a href="/attendance/record/pdf/{{ $user->id }}" 
                                        class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition-colors shadow-sm border border-gray-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection