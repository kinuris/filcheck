@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-h-screen overflow-auto">
    <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-100 max-w-4xl mx-auto">
        <div class="flex items-center border-b pb-4 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <h1 class="text-2xl font-bold text-gray-800">Delete Event</h1>
        </div>
        
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-gray-700">Are you sure you want to delete this event? This action <span class="font-semibold">cannot be undone</span>.</p>
            </div>
        </div>

        <div class="bg-gray-50 p-5 rounded-md mb-8 shadow-sm">
            <h2 class="font-semibold text-lg text-gray-700 mb-4 border-b pb-2">Event Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="transition duration-200 hover:bg-white p-3 rounded">
                    <p class="text-sm text-gray-500 uppercase tracking-wider font-medium">Name</p>
                    <p class="font-medium text-gray-800">{{ $event->name }}</p>
                </div>
                <div class="transition duration-200 hover:bg-white p-3 rounded">
                    <p class="text-sm text-gray-500 uppercase tracking-wider font-medium">Event ID</p>
                    <p class="font-medium text-gray-800">{{ $event->event_id }}</p>
                </div>
                <div class="col-span-1 md:col-span-2 transition duration-200 hover:bg-white p-3 rounded">
                    <p class="text-sm text-gray-500 uppercase tracking-wider font-medium">Description</p>
                    <p class="font-medium text-gray-800">{{ $event->description }}</p>
                </div>
                <div class="col-span-1 md:col-span-2 transition duration-200 hover:bg-white p-3 rounded">
                    <p class="text-sm text-gray-500 uppercase tracking-wider font-medium">Address</p>
                    <p class="font-medium text-gray-800">{{ $event->address }}</p>
                </div>
                <div class="transition duration-200 hover:bg-white p-3 rounded">
                    <p class="text-sm text-gray-500 uppercase tracking-wider font-medium">Start Time</p>
                    <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($event->start)->format('F j, Y g:i A') }}</p>
                </div>
                <div class="transition duration-200 hover:bg-white p-3 rounded">
                    <p class="text-sm text-gray-500 uppercase tracking-wider font-medium">End Time</p>
                    <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($event->end)->format('F j, Y g:i A') }}</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('event.destroy', $event->id) }}">
            @csrf
            <div class="flex justify-end space-x-4">
                <a href="{{ route('event.index') }}" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700 font-medium transition duration-150 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-red-600 rounded-md text-white font-medium transition duration-150 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    Delete Event
                </button>
            </div>
        </form>
    </div>
</div>
@endsection