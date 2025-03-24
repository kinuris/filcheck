@extends('layouts.admin')

@section('title', 'Faculty Attendance Log')

@section('content')
@include('components.view-logs-modal')
<div class="w-[calc(100vw-300px)] min-h-screen bg-gray-50 relative">
    <div class="w-full inline-block h-full bg-white shadow-lg">
        <div class="h-16 p-4 border-b">
            <img class="h-full" src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>

        <div class="flex flex-col p-8 mb-16 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400 h-[calc(100%-8rem)]">
            <div class="flex flex-col">
                <div class="flex w-full mb-6 justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">Attendance Log</h1>
                    <form action="/employee" class="flex flex-col gap-2">
                        <input value="{{ request()->query('search') ?? '' }}"
                            class="bg-white/90 rounded-lg border-0 shadow-lg p-3 min-w-96 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                            placeholder="Search by RFID, Employee ID or Name"
                            type="text" name="search" id="search">
                        
                        <div class="flex items-center gap-2">
                            <select name="department" class="bg-white/90 rounded-lg border-0 shadow-lg p-3 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                <option value="">All Departments</option>
                                @foreach(\App\Models\Department::all() as $department)
                                    <option value="{{ $department->id }}" {{ request()->query('department') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <select name="gender" class="bg-white/90 rounded-lg border-0 shadow-lg p-3 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                <option value="">All Genders</option>
                                <option value="Male" {{ request()->query('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ request()->query('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            
                            <button type="submit" class="bg-white/90 text-blue-600 font-semibold rounded-lg shadow-lg p-3 hover:bg-white transition-colors">
                                Filter
                            </button>
                            
                            @if(request()->query('search') || request()->query('department') || request()->query('gender'))
                                <a href="/employee" class="bg-gray-200 text-gray-800 font-medium rounded-lg p-3 hover:bg-gray-300 transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Clear Filters
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="flex gap-3 mb-4">
                    <a class="px-6 py-2 bg-white/90 text-blue-700 text-sm font-semibold rounded-lg hover:bg-white transition-colors" href="?filter=">All Records</a>
                    <a class="px-6 py-2 bg-emerald-500 text-white text-sm font-semibold rounded-lg hover:bg-emerald-600 transition-colors" href="?filter=IN">Present</a>
                    <a class="px-6 py-2 bg-red-500 text-white text-sm font-semibold rounded-lg hover:bg-red-600 transition-colors" href="?filter=OUT">Absent</a>

                    <form action="/employee" class="flex items-center ml-auto">
                        @foreach(request()->except(['_token', 'threshold']) as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $arrayKey => $arrayValue)
                                    <input type="hidden" name="{{ $key }}[{{ $arrayKey }}]" value="{{ $arrayValue }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <div class="flex items-center">
                            <label for="threshold" class="text-white text-sm font-semibold mr-2 hidden">Late Threshold:</label>
                            <input type="time" name="threshold" id="threshold" value="{{ date('H:i', strtotime($lateThreshold)) }}"
                                class="bg-white/90 rounded-lg border-0 shadow p-1.5 focus:ring-2 focus:ring-blue-300 focus:outline-none w-36">
                            <button type="submit" class="ml-2 px-4 py-2 bg-yellow-500 text-white text-sm font-semibold rounded-lg hover:bg-yellow-600 transition-colors">
                                Set Late Threshold
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white/90 rounded-lg shadow-xl overflow-hidden">
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
                        @php
                        $usersGroupedByDepartment = $users->groupBy(function($user) {
                        return $user->department ? $user->department->name : 'No Department';
                        });
                        @endphp

                        @foreach ($usersGroupedByDepartment as $departmentName => $departmentUsers)
                        <tr class="bg-gray-100">
                            <td colspan="7" class="p-2.5 font-bold text-gray-800">
                                {{ $departmentName }}
                            </td>
                        </tr>

                        @foreach ($departmentUsers as $index => $user)
                        @php($latestLog = $user->gateLogs()->where('created_at', '>=', now()->startOfDay())->latest()->first())
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-2.5">{{ $index + 1 }}</td>
                            <td class="p-2.5">{{ $user->employee_id }}</td>
                            <td class="p-2.5 font-medium">{{ $user->getFullname() }}</td>
                            @if ($latestLog)
                            <td class="p-2.5">{{ $latestLog->day }}</td>
                            <td class="p-2.5">{{ \Carbon\Carbon::parse($latestLog->time)->format('h:i A') }}</td>
                            <td class="p-2.5">
                                <div class="flex">
                                    @if ($latestLog->type == 'IN')
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium">Present</span>
                                    @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">Exited</span>
                                    @endif
                                    @if ($latestLog->time > $lateThreshold)
                                    <span class="ml-2 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-medium">Late</span>
                                    @endif
                                </div>
                            </td>
                            @else
                            <td class="p-2.5 text-gray-500">{{ date('Y-m-d') }}</td>
                            <td class="p-2.5 text-gray-500">-</td>
                            <td class="p-2.5">
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">Not Entered Today</span>
                            </td>
                            @endif
                            <td class="p-2.5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button data-info-id="{{ $user->id }}" data-modal-btn="openViewLogsModal"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View Logs
                                    </button>
                                    <a href="/teacher/attendance/record/csv/{{ $user->id }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition-colors shadow-sm border border-gray-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        CSV
                                    </a>
                                    <a href="/teacher/attendance/record/pdf/{{ $user->id }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 text-sm font-medium rounded hover:bg-gray-200 transition-colors shadow-sm border border-gray-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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

@section('script')
<script>
    const closeEmployeeLogsModal = document.getElementById('closeEmployeeLogsModal');
    if (closeEmployeeLogsModal) {
        closeEmployeeLogsModal.addEventListener('click', () => {
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.delete('emp_info');

            const newUrl = window.location.pathname + '?' + urlParams.toString();
            window.location.href = newUrl;
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all buttons with the data-modal-btn="openViewLogsModal" attribute
        const viewLogsButtons = document.querySelectorAll('[data-modal-btn="openViewLogsModal"]');

        // Add click event listener to each button
        viewLogsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-info-id');
                openViewLogsModal(userId);
            });
        });
    });

    function openViewLogsModal(userId) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('emp_info', userId);

        const newUrl = window.location.pathname + '?' + urlParams.toString();
        window.location.href = newUrl;
    }
</script>
@endsection