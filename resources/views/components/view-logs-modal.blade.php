@if (request('emp_info'))
@php 
    $info = App\Models\User::find(request('emp_info'))
@endphp
<div id="viewEmployeeLogsModal" class="fixed z-50 inset-0 bg-gray-900 bg-opacity-70 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-2/5 max-w-2xl border border-gray-100">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">
                    Employee Activity Log
                </h2>
                <div class="bg-blue-50 text-blue-700 px-2 py-1 rounded-md text-sm font-medium">
                    {{ $info->role ?? 'Employee' }}
                </div>
            </div>
            <p class="text-gray-600 mt-2 flex items-center">
                <span class="font-semibold">{{ strtoupper($info->getFullname()) }}</span>
                <span class="mx-2 text-gray-400">•</span>
                <span>{{ $info->employee_id ?? $info->phone_number}}</span>
            </p>
        </div>

        <!-- Content -->
        <div class="flex flex-col max-h-96 overflow-y-auto mt-4 custom-scrollbar">
            @php
                $grouped = $info->gateLogsByDay()
            @endphp
            @if (empty($grouped))
            <div class="flex flex-col items-center justify-center h-32 bg-gray-50 rounded-lg border border-gray-200">
                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h1 class="text-gray-500 text-lg">No activity logs found</h1>
            </div>
            @endif
            @foreach ($grouped as $day => $logs)
            @php
                $isLate = false;
                if (request('threshold') && isset($logs[0]) && $logs[0]->type === 'IN') {
                    $firstEntryTime = date_create($logs[0]->time);
                    $thresholdTime = date_create(request('threshold'));
                    $isLate = $firstEntryTime > $thresholdTime;
                }
            @endphp
            <div class="flex flex-col bg-blue-50 mb-4 p-5 rounded-lg shadow-sm border border-blue-100">
                <div class="flex justify-between items-center mb-3 border-b border-blue-100 pb-2">
                    <div class="flex items-center">
                        <p class="font-semibold text-blue-800 text-lg">{{ $day }}</p>
                        @if($isLate)
                        <span class="ml-2 text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full font-medium">Late</span>
                        @endif
                    </div>
                    <span class="text-xs bg-white px-2 py-1 rounded-full text-gray-500">{{ \Carbon\Carbon::parse($logs[0]->day . ' ' . $logs[0]->time)->diffForHumans() }}</span>
                </div>
                <ul class="space-y-3">
                    @foreach ($logs as $log)
                    <li>
                        <div class="flex items-center justify-between py-2 px-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-200 border-l-4 {{ $log->type === 'IN' ? 'border-green-500' : 'border-red-500' }}">
                            @if($log->type === 'IN')
                                @if($loop->index === 0)
                                <span class="text-green-600 font-semibold flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" />
                                    </svg>
                                    ENTERED
                                </span>
                                @else
                                <span class="text-green-600 font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59l-1.95-2.1a.75.75 0 10-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75z" />
                                    </svg>
                                    IN
                                </span>
                                @endif
                            @else
                                @if($loop->index === count($logs) - 1)
                                <span class="text-red-500 font-semibold flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 011.414-1.414L9 10.586V7a1 1 0 012 0v3.586l1.293-1.293a1 1 0 011.414 1.414z" />
                                    </svg>
                                    LEFT
                                </span>
                                @else
                                <span class="text-red-500 font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25V6.75a.75.75 0 00-1.5 0v4.59l-1.95-2.1a.75.75 0 10-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1z" />
                                    </svg>
                                    OUT
                                </span>
                                @endif
                            @endif
                            <div class="text-right">
                                <p class="text-blue-700 font-medium">{{ date_create($log->time)->format('h:i:s A') }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->day . ' ' . $log->time)->diffForHumans() }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <!-- Footer -->
        <div class="mt-6 flex justify-end border-t border-gray-200 pt-4">
            <button type="button" id="closeEmployeeLogsModal"
                class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200 flex items-center font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Close
            </button>
        </div>
    </div>
</div>
@endif

@if (request('info_id'))
@php
    $info = App\Models\StudentInfo::find(request('info_id'))
@endphp
<div id="viewLogsModal" class="fixed z-50 inset-0 bg-gray-900 bg-opacity-70 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-2/5 max-w-2xl border border-gray-100">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-4 mb-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">
                    Student Activity Log
                </h2>
                <div class="bg-blue-50 text-blue-700 px-2 py-1 rounded-md text-sm font-medium">
                    Student
                </div>
            </div>
            <p class="text-gray-600 mt-2 flex items-center">
                <span class="font-semibold">{{ strtoupper($info->full_name) }}</span>
                <span class="mx-2 text-gray-400">•</span>
                <span>{{ $info->student_number }}</span>
            </p>
        </div>

        <!-- Content -->
        <div class="flex flex-col max-h-96 overflow-y-auto mt-4 custom-scrollbar">
            @php($grouped = $info->gateLogsByDay())
            @if (empty($grouped))
            <div class="flex flex-col items-center justify-center h-32 bg-gray-50 rounded-lg border border-gray-200">
                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h1 class="text-gray-500 text-lg">No activity logs found</h1>
            </div>
            @endif
            @foreach ($grouped as $day => $logs)
            <div class="flex flex-col bg-blue-50 mb-4 p-5 rounded-lg shadow-sm border border-blue-100">
                <div class="flex justify-between items-center mb-3 border-b border-blue-100 pb-2">
                    <p class="font-semibold text-blue-800 text-lg">{{ $day }}</p>
                    <span class="text-xs bg-white px-2 py-1 rounded-full text-gray-500">{{ \Carbon\Carbon::parse($logs[0]->day . ' ' . $logs[0]->time)->diffForHumans() }}</span>
                </div>
                <ul class="space-y-3">
                    @foreach ($logs as $log)
                    <li>
                        <div class="flex items-center justify-between py-2 px-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-200 border-l-4 {{ $log->type === 'IN' ? 'border-green-500' : 'border-red-500' }}">
                            @if($log->type === 'IN')
                            @if($loop->index === 0)
                            <span class="text-green-600 font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" />
                                </svg>
                                ENTERED
                            </span>
                            @else
                            <span class="text-green-600 font-semibold flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v4.59l-1.95-2.1a.75.75 0 10-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1V6.75z" />
                                </svg>
                                IN
                            </span>
                            @endif
                            @else
                            @if($loop->index === count($logs) - 1)
                            <span class="text-red-500 font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 011.414-1.414L9 10.586V7a1 1 0 012 0v3.586l1.293-1.293a1 1 0 011.414 1.414z" />
                                </svg>
                                LEFT
                            </span>
                            @else
                            <span class="text-red-500 font-semibold flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25V6.75a.75.75 0 00-1.5 0v4.59l-1.95-2.1a.75.75 0 10-1.1 1.02l3.25 3.5a.75.75 0 001.1 0l3.25-3.5a.75.75 0 10-1.1-1.02l-1.95 2.1z" />
                                </svg>
                                OUT
                            </span>
                            @endif
                            @endif
                            <div class="text-right">
                                <p class="text-blue-700 font-medium">{{ date_create($log->time)->format('h:i:s A') }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->day . ' ' . $log->time)->diffForHumans() }}</p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <!-- Footer -->
        <div class="mt-6 flex justify-end border-t border-gray-200 pt-4">
            <button type="button" id="closeViewLogsModal"
                class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all duration-200 flex items-center font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Close
            </button>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endif