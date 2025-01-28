@extends('layouts.admin')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100 w-full">
    <div id="eventModal" class="w-full max-w-md">
        <div class="modal-container">
            <div class="bg-white rounded-lg shadow-xl p-8">
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold text-gray-800">Setup Event Node</h2>
                </div>

                <p class="mb-6 text-gray-600 text-center">
                    Setup an event node. Enter the event ID and click "Setup Event Node".
                </p>

                <form action="/event/node/setup" method="POST" class="space-y-4">
                    @csrf
                    <div class="flex border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <label for="event_id" class="bg-gray-50 px-4 py-3 text-gray-600 font-medium">
                            EVT-
                        </label>
                        <input 
                            class="w-full p-3 outline-none focus:ring-2 focus:ring-green-300"
                            maxlength="6"
                            type="text"
                            name="event_id"
                            id="event_id"
                            placeholder="Enter Event ID"
                        >
                    </div>
                    
                    <button type="submit" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg 
                        transition duration-200 ease-in-out transform hover:-translate-y-1">
                        Setup Event Node
                    </button>

                    @error('event_id')
                        <p class="text-red-500 text-sm text-center">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>
@endsection