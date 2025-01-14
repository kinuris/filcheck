@extends('layouts.admin')

@section('content')
<div class="bg-gradient-to-b from-blue-500 to-blue-400 w-full">
    <div class="w-full inline-block bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
    </div>

    <div class="px-8 py-4">
        <form class="bg-blue-300 p-4 shadow rounded-lg" action="{{ route('subject.store') }}" method="POST">
            <h1 class="text-3xl text-blue-950 mb-8">Create Subject</h1>
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Subject Name</label>
                <input type="text" name="name" id="name" class="mt-1 p-1.5 block bg-blue-300 w-full border border-blue-950 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @if ($errors->has('name'))
                <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="mb-4">
                <label for="code" class="block text-sm font-medium text-gray-700">Subject Code</label>
                <input type="text" name="code" id="code" class="mt-1 p-1.5 block bg-blue-300 w-full border border-blue-950 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @if ($errors->has('code'))
                <span class="text-red-500 text-sm">{{ $errors->first('code') }}</span>
                @endif
            </div>

            <div class="flex justify-between">
                <a href="/curriculum" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection