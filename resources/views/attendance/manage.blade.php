@extends('layouts.teacher')

@section('content')
@include('components.view-logs-modal')
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
                        <input value="{{ request()->query('search') ?? '' }}" class="bg-blue-200 rounded border-black border shadow-lg p-2 min-w-80" placeholder="RFID | STUDENT NO. | STUDENT NAME" type="text" name="search" id="search">
                    </form>
                </div>

                <div class="flex gap-2 my-3">
                    <a class="px-6 py-1 bg-blue-200 text-lg font-semibold border-2 border-black rounded-lg" href="?filter=">ALL</a>
                    <a class="px-6 py-1 bg-green-500 text-lg font-semibold border-2 border-black rounded-lg" href="?filter=IN">PRESENT</a>
                    <a class="px-6 py-1 bg-red-500 text-lg font-semibold border-2 border-black rounded-lg" href="?filter=OUT">ABSENT</a>
                </div>
            </div>

            <table class="w-full shadow-lg">
                <thead class="bg-blue-500 text-blue-950">
                    <th class="rounded-tl-lg p-2">#</th>
                    <th>STUDENT ID</th>
                    <th>FULL NAME</th>
                    <th>LEVEL</th>
                    <th>SECTION</th>
                    <th>DATE</th>
                    <th>TIME</th>
                    <th>TYPE</th>
                    <th class="rounded-tr-lg">LOGS</th>
                </thead>
                <tbody class="bg-blue-300 border-t text-center">
                    @if(empty($infos->items()))
                    <tr>
                        <td class="rounded-bl-lg p-2"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="rounded-br-lg p-2"></td>
                    </tr>
                    @endif
                    @foreach($infos as $info)
                    <tr class="@if($loop->iteration !== count($infos)) border-b @endif">
                        @if ($loop->iteration === count($infos))
                        <td class="rounded-bl-lg border-r p-2">{{ $info->id }}</td>
                        @else
                        <td class="p-2 border-r">{{ $info->id }}</td>
                        @endif
                        <td class="border-r">{{ $info->student_number }}</td>
                        <td class="border-r">{{ $info->full_name }}</td>
                        <td class="border-r">{{ $info->year }}</td>
                        <td class="border-r">{{ $info->section }}</td>
                        @php($recent = $info->gateLogs()->orderBy('day', 'DESC')->orderBy('time', 'DESC')->first())
                        @if ($recent)
                        <td class="border-r">{{ $recent->day }}</td>
                        <td class="border-r">{{ date_format(date_create($recent->time), 'h:i:s A') }}</td>

                        @if ($recent->type === 'IN')
                        <td class="border-r text-green-600 font-bold text-lg">IN</td>
                        @else
                        <td class="border-r text-red-600 font-bold text-lg">OUT</td>
                        @endif
                        @else
                        <td class="border-r">(NO RECORD)</td>
                        <td class="border-r">(NO RECORD)</td>
                        <td class="border-r">(NO RECORD)</td>
                        @endif

                        <td class="rounded-br-lg">
                            <button data-info-id="{{ $info->id }}" data-modal-btn="openViewLogsModal" class="p-1 px-2 rounded bg-blue-500 text-white font-bold">VIEW LOGS</button>
                            <a href="/attendance/record/csv/{{ $info->id }}" class="p-1 px-2 rounded bg-gray-500 text-white">CSV</a>
                            <a href="/attendance/record/pdf/{{ $info->id }}" class="p-1 px-2 rounded bg-gray-500 text-white">PDF</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div>
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