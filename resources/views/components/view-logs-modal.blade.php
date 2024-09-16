@if (request('info_id'))
@php($info = App\Models\StudentInfo::find(request('info_id')))
<div id="viewLogsModal" class="fixed z-50 inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-lg font-bold mb-2">{{ strtoupper($info->full_name) }} ({{ $info->student_number }}) LOGS</h2>

        <div class="flex flex-col max-h-96 overflow-scroll mt-4">
            @php($grouped = $info->gateLogsByDay())
            @if (empty($grouped))
            <h1 class="text-lg font-semibold">(No Logs)</h1>
            @endif
            @foreach ($grouped as $day => $logs)
            <div class="flex flex-col border bg-blue-100 mb-2 p-2 pb-4 rounded">
                <p class="font-bold">{{ $day }}</p>
                <ul class="ml-6">

                    @foreach ($logs as $log)
                    <li>
                        <div class="flex place-items-center w-64 justify-between border-b border-gray-400">
                            @if($log->type === 'IN')
                            @if($loop->index === 0)
                            <span class="text-lg text-green-600 font-bold flex-1">ENTERED</span>
                            @else
                            <span class="text-lg text-green-600 font-bold flex-1">IN</span>
                            @endif
                            @else
                            @if($loop->index === count($logs) - 1)
                            <span class="text-lg text-red-500 font-bold flex-1">LEFT</span>
                            @else
                            <span class="text-lg text-red-500 font-bold flex-1">OUT</span>
                            @endif
                            @endif
                            <p class="flex-1 text-sm">{{ date_create($log->time)->format('h:i:s A') }}</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
        <button type="button" id="closeViewLogsModal" class="mr-2 mt-3 px-4 py-2 bg-white text-blue-500 border border-blue-500 rounded">Cancel</button>
    </div>
</div>
@endif