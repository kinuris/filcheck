@extends('layouts.admin')

@section('content')
<div class="p-3">
    <div id="eventModal" class="z-10 inset-0 overflow-y-auto">
        <div class="modal-container bg-white">
            <div class="py-4 text-left px-6 shadow-lg w-fit h-fit">
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold">Setup Event Node</p>
                </div>

                <p class="mb-4 max-w-64 text-left text-sm">Setup an event node. Enter the event ID and click "Setup Event Node".</p>

                <form action="/event/node/setup" method="POST">
                    @csrf
                    <div class="flex border rounded place-items-center pl-2">
                        <label for="event_id">
                            <p class="text-gray-600">EVT-</p>
                        </label>
                        <input class="p-2 outline-none" maxlength="6" type="text" name="event_id" id="event_id">
                    </div>
                    <input class="bg-green-300 py-1.5 px-5 rounded-lg border-black border mt-3" type="submit" value="Setup Event Node">
                    @error('event_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>
@endsection