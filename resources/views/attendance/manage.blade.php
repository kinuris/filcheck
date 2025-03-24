@extends('layouts.teacher')

@section('title', 'Attendance Log')

@section('content')
@include('components.view-logs-modal')
<div class="w-full max-h-screen bg-gray-100 overflow-auto">
    <div class="w-full inline-block h-full bg-white shadow-md">
        <div class="h-16 p-4 border-b">
            <img class="h-full" src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
        <div class="p-6 max-h-[calc(100vh-4.01em)] min-h-[calc(100vh-4.01em)] bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400">
            <div class="flex flex-col max-w-5xl mx-auto">
                <div class="flex w-full mb-6 justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">Attendance Log</h1>
                    <form action="/attendance">
                        <input value="{{ request()->query('search') ?? '' }}"
                            class="bg-white rounded-lg border-0 shadow-lg p-3 w-96 focus:ring-2 focus:ring-blue-300 transition-all"
                            placeholder="Search by RFID, Student No. or Name"
                            type="text" name="search" id="search">
                    </form>
                </div>

                <div class="flex gap-3 mb-6">
                    <a class="px-6 py-2 {{ !request('filter') ? 'bg-blue-600 text-white border-2 border-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} text-sm font-semibold rounded-lg transition-colors shadow-md" href="?filter=">All Records</a>
                    <a class="px-6 py-2 {{ request('filter') == 'IN' ? 'bg-blue-600 text-white border-2 border-white' : 'bg-green-500 text-white hover:bg-green-600' }} text-sm font-semibold rounded-lg transition-colors shadow-md" href="?filter=IN">Present</a>
                    <a class="px-6 py-2 {{ request('filter') == 'OUT' ? 'bg-blue-600 text-white border-2 border-white' : 'bg-red-500 text-white hover:bg-red-600' }} text-sm font-semibold rounded-lg transition-colors shadow-md" href="?filter=OUT">Absent</a>
                </div>
            </div>

            <div class="max-w-5xl mx-auto mb-6">
                <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Student ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Full Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Time</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                            $groupedInfos = $infos->groupBy('section');
                            @endphp

                            @foreach($groupedInfos as $section => $sectionInfos)
                            <tr class="bg-gray-100">
                                <td colspan="7" class="px-4 py-2 font-semibold">Section {{ $section }}</td>
                            </tr>
                            @if($sectionInfos->isEmpty())
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">No records found</td>
                            </tr>
                            @endif
                            @foreach($sectionInfos as $info)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $info->id }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $info->student_number }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $info->full_name }}</td>
                                @php($recent = $info->gateLogs()->orderBy('day', 'DESC')->orderBy('time', 'DESC')->first())
                                @if ($recent)
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $recent->day }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ date_format(date_create($recent->time), 'h:i:s A') }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if ($recent->type === 'IN')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Present</span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Absent</span>
                                    @endif
                                </td>
                                @else
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-400">No record</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-400">No record</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-400">No record</td>
                                @endif
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button data-info-id="{{ $info->id }}" data-modal-btn="openViewLogsModal"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Logs
                                    </button>
                                    <a href="/attendance/record/csv/{{ $info->id }}"
                                        class="ml-2 inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        CSV
                                    </a>
                                    <a href="/attendance/record/pdf/{{ $info->id }}"
                                        class="ml-2 inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        PDF
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="max-w-5xl mx-auto mt-4">
                {{ $infos->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const buttons = document.querySelectorAll('button[data-modal-btn="openViewLogsModal"]');

    for (let button of buttons) {
        button.addEventListener('click', () => {
            const params = new URLSearchParams();
            params.append('info_id', button.getAttribute('data-info-id'));

            window.location.replace('/attendance?' + params.toString());
        });
    }

    const queryParams = new URLSearchParams(window.location.search);
    if (queryParams.has('info_id')) {
        const viewLogsModal = document.getElementById('viewLogsModal');
        const closeViewLogsModal = document.getElementById('closeViewLogsModal');

        viewLogsModal.classList.remove('hidden');

        closeViewLogsModal.addEventListener('click', () => {
            const url = new URL(window.location);
            url.searchParams.delete('info_id');

            window.history.replaceState({}, '', url);
            viewLogsModal.classList.add('hidden');
        });

        window.addEventListener('click', (e) => {
            if (e.target === viewLogsModal) {
                viewLogsModal.classList.add('hidden');
            }
        })
    }
</script>
@endsection