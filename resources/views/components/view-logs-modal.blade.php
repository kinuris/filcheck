@if (request('info_id'))
@php($info = App\Models\StudentInfo::find(request('info_id')))
<div id="viewLogsModal" class="fixed z-50 inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded-xl shadow-2xl w-2/5 max-w-2xl">
        <!-- Header -->
        <div class="border-b pb-4 mb-4">
            <h2 class="text-2xl font-bold text-gray-800">
                Student Activity Log
            </h2>
            <p class="text-gray-600 mt-1">
                {{ strtoupper($info->full_name) }} <span class="text-gray-400">•</span> {{ $info->student_number }}
            </p>
        </div>

        <!-- Content -->
        <div class="flex flex-col max-h-96 overflow-y-auto mt-4 custom-scrollbar">
            @php($grouped = $info->gateLogsByDay())
            @if (empty($grouped))
            <div class="flex items-center justify-center h-32">
                <h1 class="text-gray-500 text-lg">No activity logs found</h1>
            </div>
            @endif
            @foreach ($grouped as $day => $logs)
            <div class="flex flex-col bg-blue-50 mb-4 p-5 rounded-lg shadow-sm border border-blue-100">
                <p class="font-semibold text-blue-800 mb-3 text-lg">{{ $day }}</p>
                <ul class="space-y-3">
                    @foreach ($logs as $log)
                    <li>
                        <div class="flex items-center justify-between py-2 px-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 border-l-4 {{ $log->type === 'IN' ? 'border-green-500' : 'border-red-500' }}">
                            @if($log->type === 'IN')
                            @if($loop->index === 0)
                            <span class="text-green-600 font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" />
                                </svg>
                                ENTERED
                            </span>
                            @else
                            <span class="text-green-600 font-semibold">IN</span>
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
                            <span class="text-red-500 font-semibold">OUT</span>
                            @endif
                            @endif
                            <p class="text-blue-700 font-medium">{{ date_create($log->time)->format('h:i:s A') }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>

        <!-- Footer -->
        <div class="mt-6 flex justify-end border-t pt-4">
            <button type="button" id="closeViewLogsModal"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 flex items-center">
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