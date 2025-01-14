@extends('layouts.admin')

@section('content')
<div class="bg-gradient-to-b from-blue-500 to-blue-400 w-full">
    <div class="w-full inline-block bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
    </div>

    <div class="px-8 py-4">
        <form class="bg-blue-300 p-4 shadow rounded-lg" action="{{ route('room.store') }}" method="POST">
            <h1 class="text-3xl text-blue-950 mb-8">Create Room</h1>
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Room Name</label>
                <input type="text" name="name" id="name" class="mt-1 p-1.5 block bg-blue-300 w-full border border-blue-950 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="building" class="block text-sm font-medium text-gray-700">Building</label>
                <input type="text" name="building" id="building" class="mt-1 p-1.5 bg-blue-300 block w-full border border-blue-950 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <div class="flex justify-end">
                <a href="/curriculum" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-2">
                    Back
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection