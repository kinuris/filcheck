@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
<div class="w-full h-screen p-6 bg-gradient-to-br from-blue-600 via-blue-500 to-blue-400">
    <h1 class="text-4xl font-bold mb-8 text-white tracking-wide">Event Management</h1>

    <div class="flex gap-4 mb-6">
        <a href="/event/node" class="bg-emerald-600 hover:bg-emerald-700 transition-colors duration-200 text-white py-2 px-4 rounded-lg shadow-lg flex items-center gap-2">
            <span class="material-symbols-outlined">settings</span>
            <span class="font-semibold">Setup Event Node</span>
        </a>

        <div class="flex-1"></div>

        <a href="/event/create" class="bg-white hover:bg-blue-50 transition-colors duration-200 text-blue-800 py-2 px-4 rounded-lg shadow-lg flex items-center gap-2">
            <span class="material-symbols-outlined">add_circle</span>
            <span class="font-semibold">Create New Event</span>
        </a>
    </div>

    <div class="flex gap-4 mb-6">
        <label class="flex items-center gap-2 text-white">
            <input type="checkbox" id="finished" name="finished" class="w-4 h-4 rounded" {{ request('finished') === 'true' ? 'checked' : '' }}>
            <span class="font-medium">Show Finished Events</span>
        </label>
    </div>

    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-gray-700 text-sm uppercase">
                    <th class="px-6 py-4 font-semibold">Event ID</th>
                    <th class="px-6 py-4 font-semibold">Event Name</th>
                    <th class="px-6 py-4 font-semibold">Start Date</th>
                    <th class="px-6 py-4 font-semibold">End Date</th>
                    <th class="px-6 py-4 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($events as $event)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            {{ $event->event_id }}
                            <button onclick="navigator.clipboard.writeText('{{ substr($event->event_id, 4) }}')" class="text-blue-600 hover:text-blue-800">
                                <span class="material-symbols-outlined text-sm">content_copy</span>
                            </button>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium">{{ $event->name }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($event->start)->format('F j, Y, g:i a') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($event->end)->format('F j, Y, g:i a') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="/event/{{ $event->id }}/edit" class="bg-blue-600 hover:bg-blue-700 transition-colors duration-200 text-white px-4 py-2 rounded-lg">Edit</a>
                            <a href="/event/{{ $event->id }}/delete" class="bg-red-600 hover:bg-red-700 transition-colors duration-200 text-white px-4 py-2 rounded-lg">Delete</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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