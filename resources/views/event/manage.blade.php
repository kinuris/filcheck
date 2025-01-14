@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
<div class="w-full p-4 bg-gradient-to-b from-blue-500 to-blue-400">
    <h1 class="text-3xl font-bold mb-8 text-white">Events</h1>

    <div class="flex gap-2">
        <a href="/event/node" class="bg-green-600 shadow hover:bg-green-800 text-white p-2 rounded">Setup Event Node</a>

        <div class="flex-1"></div>

        <a href="/event/create" class="bg-blue-300 border-2 border-blue-800 text-blue-800 hover:bg-blue-200 p-2 rounded flex gap-2">
            <span class="material-symbols-outlined">
                add_circle
            </span>
            <p class="font-semibold">ADD EVENT</p>
        </a>
    </div>
    <div class="flex gap-2 mt-2">
        <div class="flex gap-1">
            <label for="finished" class="text-white">Finished</label>
            <input type="checkbox" id="finished" name="finished" {{ request('finished') === 'true' ? 'checked' : '' }}>
        </div>
    </div>

    <div class="flex flex-col mt-4 shadow-lg">
        <div class="h-2 w-full bg-blue-300 rounded-t-lg">
        </div>

        <table class="w-full text-blue-950">
            <thead class="text-left bg-blue-300">
                <th class="p-2 mb-2 border-b border-blue-950">Event ID</th>
                <th class="border-b border-blue-950">Event Name</th>
                <th class="border-b border-blue-950">Start</th>
                <th class="border-b border-blue-950">End</th>
                <th class="border-b border-blue-950">Actions</th>
            </thead>
            <tbody>
                @foreach ($events as $event)
                <tr class="text-left bg-blue-300">
                    <td class="px-2 py-3 border-b border-blue-950">{{ $event->event_id }}</td>
                    <td class="border-b border-blue-950">{{ $event->name }}</td>
                    <td class="border-b border-blue-950">{{ \Carbon\Carbon::parse($event->start)->format('F j, Y, g:i a') }}</td>
                    <td class="border-b border-blue-950">{{ \Carbon\Carbon::parse($event->end)->format('F j, Y, g:i a') }}</td>
                    <td class="border-b border-blue-950">
                        <div class="flex justify-start">
                            <a href="/event/{{ $event->id }}/edit" class="bg-blue-600 hover:bg-blue-800 text-white p-2 rounded mr-1">Edit</a>
                            <a href="/event/{{ $event->id }}/delete" class="bg-red-600 hover:bg-red-800 text-white p-2 rounded">Delete</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="h-2 w-full bg-blue-300 rounded-b-lg">
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const finished = document.getElementById('finished');
    finished.addEventListener('change', (e) => {
        const urlParams = new URLSearchParams(window.location.search);

        urlParams.set('finished', e.target.checked);
        window.location.search = urlParams;
    });
</script>
@endsection